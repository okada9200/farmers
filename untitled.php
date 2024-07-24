<?php

class Card
{
    public $value;
    public $suit;

    public function __construct($value, $suit)
    {
        $this->value = $value;
        $this->suit = $suit;
    }

    public function display()
    {
        return "{$this->suit}の{$this->value}";
    }
}

class Player
{
    public $name;
    public $hand;

    public function __construct($name)
    {
        $this->name = $name;
        $this->hand = [];
    }

    public function drawCard($card)
    {
        $this->hand[] = $card;
    }

    public function playCard()
    {
        return array_pop($this->hand);
    }

    public function hasCards()
    {
        return count($this->hand) > 0;
    }
}

class WarGame
{
    public $players;

    public function __construct($playerNames)
    {
        $this->players = [];
        foreach ($playerNames as $name) {
            $this->players[] = new Player($name);
        }
    }

    public function startGame()
    {
        echo "戦争を開始します。\n";

        // カードの生成
        $deck = [];
        $suits = ['ハート', 'ダイヤ', 'スペード', 'クラブ'];
        $values = ['A', 'K', 'Q', 'J', '10', '9', '8', '7', '6', '5', '4', '3', '2', 'Joker'];

        foreach ($suits as $suit) {
            foreach ($values as $value) {
                $deck[] = new Card($value, $suit);
            }
        }

        // カードをシャッフル
        shuffle($deck);

        // カードを配る
        $playerCount = count($this->players);
        for ($i = 0; $i < count($deck); $i++) {
            $this->players[$i % $playerCount]->drawCard($deck[$i]);
        }

        echo "カードが配られました。\n";

        $round = 1;
        while ($this->gameOn()) {
            echo "戦争！\n";
            $this->playRound($round);
            $round++;
        }

        $this->endGame();
    }

    public function playRound($round)
    {
        $playedCards = [];
        foreach ($this->players as $player) {
            if ($player->hasCards()) {
                $card = $player->playCard();
                echo "{$player->name}のカードは{$card->display()}です。\n";
                $playedCards[$player->name] = $card;
            }
        }

        if (empty($playedCards)) {
            echo "プレイヤーの手札がなくなったため、ゲームを終了します。\n";
            return;
        }

        $winningPlayer = $this->compareCards($playedCards);

        if ($winningPlayer) {
            echo "{$winningPlayer->name}が勝ちました。\n";
            $this->giveCardsToPlayer($winningPlayer, $playedCards);
        } else {
            echo "引き分けです。\n";
        }
    }

    public function compareCards($playedCards)
    {
        $values = [];
        foreach ($playedCards as $player => $card) {
            if ($card->value === 'A' && $card->suit === 'スペード') {
                return $this->getPlayerByName($player); // 「世界一」の場合、そのプレイヤーが勝利
            }
            $values[$player] = $this->cardValue($card->value);
        }

        arsort($values);
        $keys = array_keys($values);
        $maxValue = reset($values);

        $occurrences = array_count_values($values);
        if ($occurrences[$maxValue] > 1) {
            return null; // 引き分け
        }

        return $this->getPlayerByName($keys[0]);
    }

    public function cardValue($value)
    {
        $values = ['Joker' => 15, 'A' => 14, 'K' => 13, 'Q' => 12, 'J' => 11, '10' => 10, '9' => 9, '8' => 8, '7' => 7, '6' => 6, '5' => 5, '4' => 4, '3' => 3, '2' => 2];
        return $values[$value]; 
    }

    public function giveCardsToPlayer($player, $cards)
    {
        foreach ($cards as $card) {
            $player->drawCard($card);
        }
    }

    public function getPlayerByName($name)
    {
        foreach ($this->players as $player) {
            if ($player->name === $name) {
                return $player;
            }
        }
        return null;
    }

    public function gameOn()
    {
        $activePlayers = array_filter($this->players, function ($player) {
            return $player->hasCards();
        });

        return count($activePlayers) > 1;
    }

    public function endGame()
    {
        echo "戦争を終了します。\n";

        // 順位を表示
        usort($this->players, function ($a, $b) {
            return count($b->hand) - count($a->hand);
        });

        foreach ($this->players as $index => $player) {
            echo "{$player->name}が" . ($index + 1) . "位です。";
            echo " 手札の枚数は" . count($player->hand) . "枚です。\n";
        }
    }
}

echo "戦争を開始します。\n";
echo "プレイヤーの人数を入力してください（2〜5）: ";
$playerCount = readline();
if ($playerCount < 2 || $playerCount > 5) {
    echo "プレイヤーの人数は2〜5で入力してください。\n";
    exit;
}

$playerNames = [];
for ($i = 1; $i <= $playerCount; $i++) {
    echo "プレイヤー{$i}の名前を入力してください: ";
    $playerNames[] = readline();
}

$game = new WarGame($playerNames);
$game->startGame();

?>
