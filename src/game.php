<?php
/*
    This file is part of Erebot.

    Erebot is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Erebot is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Erebot.  If not, see <http://www.gnu.org/licenses/>.
*/

if (!defined('__DIR__')) {
  class __FILE_CLASS__ {
    function  __toString() {
      $X = debug_backtrace();
      return dirname($X[1]['file']);
    }
  }
  define('__DIR__', new __FILE_CLASS__);
} 

require_once(__DIR__.'/exceptions.php');
require_once(__DIR__.'/decks.php');
require_once(__DIR__.'/hand.php');

class   GoF
{
    protected $deck;
    protected $order;
    protected $players;
    protected $startTime;
    protected $creator;
    protected $leader;

    const DIR_COUNTERCLOCKWISE      = FALSE;
    const DIR_CLOCKWISE             = TRUE;

    public function __construct($creator, GoFDeck &$deck)
    {
        $this->creator      =&  $creator;
        $this->deck         =   $deck;
        $this->players      =   array();
        $this->startTime    =   NULL;
        $this->leader       =   NULL;
    }

    public function __destruct()
    {
        
    }

    public function & join($token)
    {
        $nbPlayers = count($this->players);
        if ($nbPlayers >= 4)
            throw new EGoFEnoughPlayersAlready();

        $this->players[]    = new GoFHand($token, $this->deck);
        $player             = end($this->players);
        if (count($this->players) == 3) {
            $this->startTime = time();
            shuffle($this->players);
        }
        return $player;
    }

    public function play($combo)
    {
        
    }

    public function pass()
    {
        
    }

    public function chooseCard($card)
    {
        
    }

    public function getCurrentPlayer()
    {
        return reset($this->players);
    }

    public function & getLeadingPlayer()
    {
        return $this->leader;
    }

    public function & getCreator()
    {
        return $this->creator;
    }

    public function getElapsedTime()
    {
        if ($this->startTime === NULL)
            return NULL;

        return time() - $this->startTime;
    }

    public function getLastPlayedCombo()
    {
        return $this->deck->getLastDiscardedCombo();
    }

    public function & getPlayers()
    {
        return $this->players;
    }
}

# vim: et ts=4 sts=4 sw=4
