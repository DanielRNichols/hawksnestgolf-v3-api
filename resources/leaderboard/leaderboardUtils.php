<?php

require_once(__DIR__."/Leaderboard.php");

function getLeaderboardFromJson ($jsonFile)
{
    $json = file_get_contents($jsonFile);
    return json_decode($json, true);
}

function getLeaderboard ($con, $timestamp, $jsonFile, $fedExCupScoring) 
{
    $data = getLeaderboardFromJson($jsonFile);

    if(($timestamp != null) && ($timestamp == $data['time_stamp']))
    {
        return null;
    }

    $leaderboard['info']['timestamp'] = $data['time_stamp'];
    $leaderboard['info']['lastUpdated'] = $data['last_updated'];

    $leaderboardData = $data['leaderboard'];

    $leaderboard['info']['tournamentname'] = $leaderboardData['tournament_name'];
    $leaderboard['info']['round'] = $leaderboardData['current_round'];
    $leaderboard['info']['state'] = $leaderboardData['round_state'];

    $leaderboard['info']['cutline'] = $leaderboardData['cut_line']["cut_line_score"];
    $leaderboard['info']['cutcount'] = $leaderboardData['cut_line']["cut_count"];


    $courseData = $leaderboardData['courses'][0];
    $leaderboard['info']['coursename'] = $courseData['course_name'];
    $leaderboard['info']['par'] = $courseData['par_total'];

    foreach($leaderboardData['courses'] as $course)
    {
        $courseId = $course['course_id'];
        $leaderboard['courses'][$courseId]['coursename'] = $course['course_name'];
        $leaderboard['courses'][$courseId]['par'] = $course['par_total'];
        foreach($course['holes'] as $hole)
        {
            $holeNo = $hole['hole_id'];
            $leaderboard['courses'][$courseId]['holes'][$holeNo-1]['hole'] = $holeNo;
            $leaderboard['courses'][$courseId]['holes'][$holeNo-1]['par'] = $hole['round'][0]['par'];
        }
    }



    //var_dump($leaderboard);
    $players = $leaderboardData['players'];

    $owners = getOwnersForSelectedGolfers($con);


    $idIndex = array();
    $numActivePlayers = 0;
    $numPlayers = count($players);
    for ($i = 0; $i < $numPlayers; $i++) {

        $player = $players[$i];
        $pgaTourId = strval($player['player_id']);
        $idIndex[$pgaTourId] = $i;
        
        $golfer = new \HawksNestGolf\Resources\Leaderboard\LeaderboardGolfer($pgaTourId);
        $golfer->lbIndex = $i;
          
        $player_bio = $player['player_bio'];
        $golfer->name = $player_bio['first_name'].' '.$player_bio['last_name'];
        $golfer->selectionName = strtoupper($player_bio['last_name'].', '
                                 .strtoupper(substr($player_bio['first_name'],0,1)).'.');
 
        $golfer->country = $player_bio['country'];
        
        $golfer->courseId = $player['course_id'];
        $golfer->pos = $player['current_position'];
        $golfer->total = $player['total'];
        $golfer->thru = $player['thru'];
        $golfer->move = calcMove($player['start_position'], $player['current_position']);
        $golfer->status = $player['status'];
        $golfer->statusSort = getStatusSort($golfer);
        $golfer->round = $player['today'];
        $golfer->startHole = $player['start_hole'];
        
        $rankings = $player['rankings'];
        $golfer->fedExRanking = $rankings['cup_rank'];
        $golfer->projectedFedExRanking = $rankings['projected_cup_rank'];
        $golfer->projectedFedExPoints = $rankings['projected_cup_points_total'];
        $golfer->fedExMove = $golfer->fedExRanking - $golfer->projectedFedExRanking;

        $holes = $player['holes'];

        $golfer->scorecard = null;
        foreach ($holes as $hole)
        {
            $holeNo = $hole['course_hole_id'];
            $golfer->scorecard[] = array(
                'no' => $holeNo,
                'par' => $hole['par'],
                'score' => $hole['strokes']
            );
        }

        $golfer->rounds = $player['rounds'];
        foreach($player['rounds'] as $currRound)
        {
            $rounds[$currRound['round_number']] = $currRound['strokes'];
        }

        // If round 2 is complete, we still want to set $round today's score
        if(($golfer->status == 'cut') && ($golfer->round == null) && ($leaderboard['info']['round'] == 2))
        {

            $golfer->round = $rounds[2] - $leaderboard['info']['par'];
        }
        
        // We need pos set for mdf so that they are considered in calculating points
        if($golfer->status == 'mdf') {
            $golfer->pos = 'MDF'.$golfer->total;
            //$golfer->status = 'active';
        }

        if(($golfer->status == 'active') || ($golfer->status == 'mdf'))
            $numActivePlayers++;

        $golfer->owner = isset($owners[$pgaTourId]) ? $owners[$pgaTourId] : "";

        $leaderboard["golfers"][$i] = $golfer;


    }
    
   
    if(!$fedExCupScoring) {
        
        // Update points based on position
        $posPoints = array();
        $points = $numActivePlayers;
        for ($i = 0; $i < $numActivePlayers; $i++) {
            $golfer = $leaderboard["golfers"][$i];

            if(($golfer->status == 'active') || ($golfer->status == 'mdf')) {
                $pos = $golfer->pos;
                if(!isset($posPoints[$pos])) {
                    $posPoints[$pos]['total'] = $points--;
                    $posPoints[$pos]['count'] = 1;
                }
                else {
                    $posPoints[$pos]['total'] += $points--;
                    $posPoints[$pos]['count'] += 1;
                }
                $posPoints[$pos]['value'] = $posPoints[$pos]['total'] / $posPoints[$pos]['count'];
            }
        }

        for ($i = 0; $i < $numPlayers; $i++) {
            $golfer = $leaderboard["golfers"][$i];
            if((($golfer->status == 'active') || ($golfer->status == 'mdf')) && isset($posPoints[$golfer->pos]))
                $golfer->points = $posPoints[$golfer->pos]['value'];
        }
    } else {
        // sort leaderboard by fedex points
        usort($leaderboard["golfers"], function($a, $b) {
                return $a->projectedFedExPoints < $b->projectedFedExPoints;
                });
    
        // golfers may be in FedEx Cup Playoffs but not in the current event
        // Add them to the leaderboard and calculate their projected ranking based on their current points
        addGolfersInFedExNotOnLeaderboard($leaderboard, $idIndex);

        // sort again after adding missing golfers
        usort($leaderboard["golfers"], function($a, $b) {
                return $a->projectedFedExPoints < $b->projectedFedExPoints;
                });
    
        $posPoints = array();
        $numSpots = 70;
        $points = $numSpots;
        $i = 0;
        foreach($leaderboard["golfers"] as $golfer) {
            // reset the index because we sorted and added new golfers
            $golfer->lbIndex = $i;
            if($golfer->projectedFedExRanking <= $numSpots ) {
                $golfer->points = $numSpots - $golfer->projectedFedExRanking + 1;
            } else {
                $golfer->points = 0;
            }
        }
    }
    
    $leaderboard['teams'] = getTeams($con, $leaderboard, $idIndex, $fedExCupScoring);
                
    //return null;
    return (isset($leaderboard) ? $leaderboard : null);
}

function addGolfersInFedExNotOnLeaderboard(&$leaderboard, &$idIndex) {
    var_dump('In addGolfersInFedExNotOnLeaderboard');
    $fieldController = new \HawksNestGolf\Resources\Field\FieldController();
    $field = $fieldController->get(0, null);
    $leaderboardCount = count($leaderboard["golfers"]);
   
    
    foreach($field as $fieldEntry) {
        $pgaTourId = $fieldEntry->pgaTourId;
        if(!array_key_exists($pgaTourId, $idIndex)) {
            //var_dump($pgaTourId);
            $golfer = new \HawksNestGolf\Resources\Leaderboard\LeaderboardGolfer($pgaTourId);
            $golfer->lbIndex = $leaderboardCount;
            $golfer->id = $fieldEntry->golfer->id;
            $golfer->name = $fieldEntry->golfer->name;
            $golfer->country = $fieldEntry->golfer->country;
            $golfer->fedExRanking = $fieldEntry->golfer->fedExRanking;
            $golfer->projectedFedExPoints = $fieldEntry->golfer->fedExPoints;
            //$golfer->projectedFedExRanking = $fieldEntry->golfer->fedExRanking;
            $golfer->projectedFedExRanking = getFedExRankingForDNS($leaderboard, $fieldEntry->golfer->fedExPoints);

            $golfer->fedExMove = $golfer->fedExRanking - $golfer->projectedFedExRanking;
            
            //var_dump($golfer);
            // Add golfer to leaderboard and idIndex
            $leaderboard["golfers"][$leaderboardCount++] = $golfer;
            $idIndex[$pgaTourId] = $golfer->lbIndex;
            
        }
    }
    
    //var_dump($leaderboard);
}

function getFedExRankingForDNS($leaderboard, $fedExPoints) {
    
    foreach($leaderboard["golfers"] as $golfer) {
        if($golfer->projectedFedExPoints <= $fedExPoints) {
            return $golfer->projectedFedExRanking-1;
        }
    }
 
    
    return ;
}

function getOwnersForSelectedGolfers ($con)
{
    $query = "select players.name, golfers.pgatourid
                from selectionentries, selectionpicks, players, golfers 
                where 
                    selectionentries.id = selectionpicks.entryid and
                    selectionpicks.golferId=golfers.id and
                    selectionentries.playerid = players.id
                order by selectionentries.id, selectionpicks.round";

    if ($stmt = $con->prepare($query)) 
    {
        $stmt->execute();
        $stmt->bind_result($playerName, $pgaTourId);
        $i = 0;
        while ($stmt->fetch()) 
        {
            $selectedGolfers[$pgaTourId] = $playerName;
        }
        $stmt->close();
    }       
    return(isset($selectedGolfers) ? $selectedGolfers : null);
}
    
function calcMove($startPosStr, $currPosStr) 
{
    $move = 0;
    if(($startPosStr != "") && ($currPosStr != ""))
    {
        if($startPosStr[0] == "T")
            $startPosStr = substr($startPosStr, 1);
        if($currPosStr[0] == "T")
            $currPosStr = substr($currPosStr, 1);

        $startPos = intval($startPosStr);
        $currPos = intval($currPosStr);

        if(($startPos > 0) && ($currPos > 0))
            $move = $startPos - $currPos;
    }

    return($move);
}


function getStatusSort($golfer) 
{
    if($golfer->status == 'mdf')
        $retVal = 'active';
    else
        $retVal = $golfer->status;
    
    return $retVal;
}


function getTeams ($con, $leaderboard, $idIndex, $fedExCupScoring)
{

    $query = "select selectionentries.id, players.id, players.name, selectionentries.picknumber, 
                    selectionpicks.round, golfers.pgatourid, golfers.name, golfers.country, golfers.fedexpoints
            from selectionentries, selectionpicks, players, golfers
            where 
                selectionentries.id = selectionpicks.entryid and
                selectionpicks.golferId=golfers.id and
                selectionentries.playerid = players.id 
            order by selectionentries.id, selectionpicks.round";
    


    if ($stmt = $con->prepare($query)) 
    {
        $stmt->execute();
        $stmt->bind_result($entryId, $playerId, $playerName, $pickNum, $round, $pgaTourId, $golferName, $country, $fedExPoints);
        $i = 0;
        while ($stmt->fetch()) 
        {
            
            if(array_key_exists($pgaTourId, $idIndex))
            {
                $lbIndex = $idIndex[$pgaTourId];
                $golfer = $leaderboard['golfers'][$lbIndex];
                $pick = array("round" => $round, "id" => $pgaTourId, "lbIndex" => $lbIndex);
            }
            else
            {
                $lbIndex = -1;
                $golfer = null;
                $pick = array("round" => $round, "id" => $pgaTourId, "lbIndex" => $lbIndex,
                                "name" => $golferName, "country" => $country, "status" => 'dns');
            }
            
            if(isset($teams) && array_key_exists($entryId, $teams)) 
            {
                $teams[$entryId]->picks[] = $pick;
            }
            else
            {
                $team = new \HawksNestGolf\Resources\Leaderboard\Team($entryId, $playerName, $pickNum);
                $team->picks[] = $pick;
                $teams[$entryId] = $team;
            }
            if($golfer != null) 
            {
                $teams[$entryId]->pointTotal += $golfer->points;
                if(($golfer->status == 'active') || ($golfer->status == 'mdf'))
                        $team->numActive += 1;
            }

        }

        $stmt->close();
        
    }  
    
 
    if(isset($teams))
    {
        //var_dump($teams);
        $round = $leaderboard["info"]["round"];
        $calcDayMoney = ($round <= 2) && !fedExCupScoring;
        if($calcDayMoney)
        {
            // Update Team Day Money Scores and number inside cutline
            $cutline = $leaderboard["info"]["cutline"];
            foreach ($teams as $entryId => $team) 
            {
                $maxScore = null;
                $picks = $team->picks;
                foreach ($picks as $roundSelected => $pickData)
                {
                    $lbIndex = $pickData["lbIndex"];
                    if($lbIndex >= 0)
                    {
                        $golfer = $leaderboard['golfers'][$lbIndex];
                        if(($golfer->status == 'active') || ($golfer->status == 'cut'))
                        {
                            $team->score += $golfer->round;
                            if(is_null($maxScore))
                                $maxScore = $golfer->round;
                            else
                                max($maxScore, $golfer->round);
                            if($golfer->status == 'active')
                            {
                                //$team->numActive += 1;
                                if(($round == 2) && ($golfer->total <= $cutline))
                                    $team->numInsideCut += 1;
                            }
                        }
                        else
                            $team->numWD += 1;
                    }
                    else
                        $team->numWD += 1;

                }
                // should be getting dropLowest from tournament or event table
                $dropLowest = true;
                if($dropLowest) {
                    if($team->numWD == 0)
                        $team->score -= $maxScore;
                    else if ($team->numWD > 1)
                        $team->status = 'dq';
                } else if ($team->numWD > 0) {
                        $team->status = 'dq';
                }
            }
        }
        
        
        if($calcDayMoney)
            assignTeamPositions($teams, "compareTeamsByScores");
        else
            assignTeamPositions($teams, "compareTeamsByPoints");
        //var_dump($teams);

    }

    return(isset($teams) ? array_values($teams) : null);
}


function assignTeamPositions($teams, $compareFuncName)
{
    usort($teams, $compareFuncName);
    
    $numTeams = count($teams);
    $currPos = '';
    for($i = 0; $i < $numTeams; $i++)
    {
        if(($i > 0) && (call_user_func($compareFuncName, $teams[$i], $teams[$i-1], false) == 0))
            $currPos = $currPos;
        else if(($i < ($numTeams-1)) && (call_user_func($compareFuncName, $teams[$i], $teams[$i+1], false) == 0))
        {
            $currPos = 'T'.($i+1);
        }
        else
        {
            $currPos = $i+1;
            
        }
        $teams[$i]->lbIndex = $i+1;
        $teams[$i]->position = $currPos;
    } 
}

function compareTeamsByPointsBreakTies($teamA, $teamB)
{
    return compareTeamsByPoints($teamA, $teamB, true);
}

    
function compareTeamsByPointsAllowTies($teamA, $teamB)
{
        return compareTeamsByPoints($teamA, $teamB, false);
}


function compareTeamsByPoints($teamA, $teamB, $breakTies=true)
{
    $retVal = 0;
    
    if($teamA->status == 'dq')
        $retVal = 1;
    else if ($teamB->status == 'dq')
        $retVal = -1;
    else if ($teamA->pointTotal == $teamB->pointTotal)
    {
        if($breakTies)
            $retVal = (($teamA->teamNo < $teamB->teamNo) ? -1 : 1);
        else
            $retVal = 0;
    }
    else
        $retVal = ($teamA->pointTotal > $teamB->pointTotal ? -1 : 1);
    
    return $retVal;
}

function compareTeamsByScoresBreakTies($teamA, $teamB)
{
    return compareTeamsByScores($teamA, $teamB, true);
}

    
function compareTeamsByScoresAllowTies($teamA, $teamB)
{
        return compareTeamsByPoints($teamA, $teamB, false);
}

function compareTeamsByScores($teamA, $teamB, $breakTies=true)
{
    $retVal = 0;
    
    if($teamA->status == 'dq')
        $retVal = 1;
    else if ($teamB->status == 'dq')
        $retVal = -1;
    else if ($teamA->score == $teamB->score)
    {
        if($breakTies)
            $retVal = (($teamA->teamNo < $teamB->teamNo) ? -1 : 1);
        else
            $retVal = 0;
    }
    else
        $retVal = ($teamA->score < $teamB->score ? -1 : 1);

    return $retVal;
}

function getScorecard($pgaTourId)
{
    $data = getLeaderboardFromJson();
    $leaderboardData = $data['leaderboard'];
    $players = $leaderboardData['players'];

    $numPlayers = count($players);
    $found = false;
    for ($i = 0; $i < $numPlayers && !$found; $i++) {
        $found = ($players[$i]['player_id'] == $pgaTourId);
        if($found) 
        {
            for($j = 0; $j < 18; $j++)
            {
                $scorecard[$j]['score'] = null;
            }

            $holes = $players[$i]['holes'];

            foreach ($holes as $hole)
            {
                $holeNo = $hole['course_hole_id'];
                $scorecard[$holeNo-1]['hole'] = $holeNo;
                $scorecard[$holeNo-1]['par'] = $hole['par'];
                $scorecard[$holeNo-1]['score'] = $hole['strokes'];
            }
        }


    }

    return(isset($scorecard) ? $scorecard : null);
}


