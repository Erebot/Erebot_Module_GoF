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

class   Erebot_Module_GoF_CardTest
extends PHPUnit_Framework_TestCase
{
    public function testRejectInvalidCards()
    {
        $cards = array(
            0,
            'r',
            'g0',
            'y0',
            'r0',
            '0',
            'rg',
            'x0',
            'xd',
            'xy',
            'gd',
            'yd',
            'rp',
            'm0',
            'm2',
            'm3',
            'm4',
            'm5',
            'm6',
            'm7',
            'm8',
            'm9',
            'mp',
            'md',
            'g11',
        );
        foreach ($cards as $card) {
            try {
                Erebot_Module_GoF_Card::fromLabel($card);
                $this->fail("Expected an EGoFInvalidCard exception.");
            }
            catch (Erebot_Module_GoF_InvalidCardException $e) {
                // Okay.
            }
        }
    }

    public function validCardsProvider()
    {
        return array(
            // Red serie
            array(
                'r1',
                Erebot_Module_GoF_Card::COLOR_RED,
                Erebot_Module_GoF_Card::VALUE_1
            ),
            array(
                'r10',
                Erebot_Module_GoF_Card::COLOR_RED,
                Erebot_Module_GoF_Card::VALUE_10
            ),
            array(
                'rd',
                Erebot_Module_GoF_Card::COLOR_RED,
                Erebot_Module_GoF_Card::VALUE_DRAGON
            ),
            // Green serie
            array(
                'g1',
                Erebot_Module_GoF_Card::COLOR_GREEN,
                Erebot_Module_GoF_Card::VALUE_1
            ),
            array(
                'g10',
                Erebot_Module_GoF_Card::COLOR_GREEN,
                Erebot_Module_GoF_Card::VALUE_10
            ),
            array(
                'gp',
                Erebot_Module_GoF_Card::COLOR_GREEN,
                Erebot_Module_GoF_Card::VALUE_PHOENIX
            ),
            // Yellow serie
            array(
                'y1',
                Erebot_Module_GoF_Card::COLOR_YELLOW,
                Erebot_Module_GoF_Card::VALUE_1
            ),
            array(
                'y10',
                Erebot_Module_GoF_Card::COLOR_YELLOW,
                Erebot_Module_GoF_Card::VALUE_10
            ),
            array(
                'yp',
                Erebot_Module_GoF_Card::COLOR_YELLOW,
                Erebot_Module_GoF_Card::VALUE_PHOENIX
            ),
            // Multicolor serie
            array(
                'm1',
                Erebot_Module_GoF_Card::COLOR_MULTI,
                Erebot_Module_GoF_Card::VALUE_1
            ),
        );
    }

    /**
     * @dataProvider validCardsProvider
     */
    public function testAcceptValidCards($label, $color, $value)
    {
        $card = Erebot_Module_GoF_Card::fromLabel($label);
        $this->assertEquals($color, $card->getColor());
        $this->assertEquals($value, $card->getValue());
        $this->assertEquals($label, (string) $card);
    }

    public function cardsForComparison()
    {
        return array(
            array('g1', 'g1', NULL),
            array('y1', 'g1', TRUE),
            array('r1', 'y1', TRUE),
            array('m1', 'r1', TRUE),
            array('g2', 'm1', TRUE),
            array('gp', 'r10', TRUE),
            array('yp', 'gp', TRUE),
            array('rd', 'yp', TRUE),
        );
    }

    /**
     * @dataProvider cardsForComparison
     */
    public function testCardComparison($c1, $c2, $result)
    {
        $card1 = Erebot_Module_GoF_Card::fromLabel($c1);
        $card2 = Erebot_Module_GoF_Card::fromLabel($c2);
        if ($result === NULL)
            $this->assertEquals(0, Erebot_Module_GoF_Card::compareCards($card1, $card2));
        else if ($result === TRUE)
            $this->assertGreaterThan(0, Erebot_Module_GoF_Card::compareCards($card1, $card2));
        else
            $this->assertLessThan(0, Erebot_Module_GoF_Card::compareCards($card1, $card2));
    }
}

