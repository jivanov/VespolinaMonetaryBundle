<?php
/**
 * (c) 2011 Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vespolina\MonetaryBundle\Service;

use Vespolina\MonetaryBundle\Model\CurrencyInterface;
use Vespolina\MonetaryBundle\Service\CurrencyExchanger;
 
/**
 * @author Richard Shank <develop@zestic.com>
 */
class GoogleCurrencyExchanger extends CurrencyExchanger
{
    /**
     * @inheritdoc
     */
    public function getExchangeRate($from, $to, \DateTime $datetime=null)
    {
        $from = $this->extractCode($from);
        $to = $this->extractCode($to);
        $url = sprintf("http://www.google.com/ig/calculator?hl=en&q=1%s%%3D%%3F%s", $from, $to);
        $conversion = file_get_contents($url);

        preg_match('/lhs:\s*"([0-9\.]+)\s/', $conversion, $_from);
        preg_match('/rhs:\s*"([0-9\.]+)\s/', $conversion, $_to);

        $rate = bcdiv($_from[1], $_to[1], 8); // PEN/USD (26) / EUR/USD (7)
        return $rate;
    }
}