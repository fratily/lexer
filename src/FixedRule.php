<?php
/**
 * FratilyPHP Lexer
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.
 * Redistributions of files must retain the above copyright notice.
 *
 * @author      Kento Oka <kento-oka@kentoka.com>
 * @copyright   (c) Kento Oka
 * @license     MIT
 * @since       1.0.0
 */
namespace Fratily\Lexer;

/**
 *
 */
class FixedRule extends Rule{

    /**
     * @var int
     */
    private $length;

    /**
     * {@inheritdoc}
     */
    public function matchedLength(string $string): int{
        if($this->length === null){
            $this->length   = mb_strlen($this->getMatch());
        }

        if(0 < $this->length){
            if(mb_substr($string, 0, $this->length) === $this->getMatch()){
                return $this->length;
            }
        }

        return 0;
    }
}