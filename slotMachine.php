<?php
/*
Create a slot-machine with a field of 5 x 3
You insert amount of money you would like to play with
Chose amount you would like to gamble with for 1 line (bet)
Chose amount of lines of success-full combinations
After each spin displays game screen + money earned/lost + balance left in the machine
 */

function spinTheWheel():array{
    $board = array_fill(0, 15, 0);
    for ($i = 0; $i < 15; $i++){
        echo ($i % 5 == 0) ? PHP_EOL: '';
        echo $board[$i] = rand(1,2) . ' ';
    }
    echo PHP_EOL . PHP_EOL;
    return $board;
}

function checkWinnings($board, $bet, $linesCount):int{
    $winningCombos = [
        1 => [1,2,3,4,5],
        2 => [5,6,7,8,9],
        3 => [10,11,12,13,14],
        4 => [0,6,12,8,4],
        5 => [10,6,2,8,14],
        6 => [0,6,7,8,14],
        7 => [10,6,7,8,4],
        8 => [5,1,2,3,9],
        9 => [5,11,12,13,9],
        10 => [0,6,2,8,9],
        11 => [5,11,7,13,14],
        12 => [10,6,12,8,14],
        13 => [5,1,7,3,9]
    ];
    $spinReward = 0;
    $lineReward = (int)$bet;
    for ($i = 1; $i <= $linesCount; $i++){
        if ($board[$winningCombos[$i][0]] == $board[$winningCombos[$i][1]] &&
            $board[$winningCombos[$i][0]] == $board[$winningCombos[$i][2]] &&
            $board[$winningCombos[$i][0]] == $board[$winningCombos[$i][3]] &&
            $board[$winningCombos[$i][0]] == $board[$winningCombos[$i][4]]){
            echo 'You won: ' . $lineReward * 10 . PHP_EOL;
            $spinReward += $lineReward * 10;
        }
    }
    if ($spinReward == 0){
        echo 'No matches' . PHP_EOL;
    }
    return $spinReward;
}

$moneyInSlotMachine = readline('Enter how much money are You willing to gamble today(In Euros): ');
echo PHP_EOL . 'Your Money is transformed to credits - 1 Euro = 100 credits' . PHP_EOL;
$start = readline('Start game? (y/n)');
if ($start != 'y') {
    echo PHP_EOL . "Cashing out - $moneyInSlotMachine Euros" . PHP_EOL .
        'Thank You for playing';
}else{
    $bet = readline('Enter how much You are willing to bet for 1 line of succession: ');
    echo 'Enter the success-full line combinations you want to gamble on (Maximum lines - 13)' . PHP_EOL;
    $linesCount = readline('Recommended options = 3/5/9/13 lines : ');
    echo PHP_EOL;

    $credits = $moneyInSlotMachine * 100;
    $continuer = ' ';

    while ($continuer != '  '){

        $credits -= $bet * $linesCount;

        $board = spinTheWheel();
        $spinReward = checkWinnings($board, $bet, $linesCount);

        $credits += $spinReward;
        echo "Credits left: $credits" . PHP_EOL;

        echo ' 1. - Spin again?' . PHP_EOL .
            '2. - Cash out' . PHP_EOL;
        $continuer = readline('Your choice? : ');
        echo PHP_EOL;

       if ($credits < $bet * $linesCount){
           echo 'You dont have enough money left' . PHP_EOL;
           echo 'Machine returns ' . $credits /100 . 'Euros' . PHP_EOL;
           return;
       }

       if ($continuer == 2){
           echo 'Machine returns ' . $credits / 100 . ' Euros' . PHP_EOL;
           return;
       }
    }
}
