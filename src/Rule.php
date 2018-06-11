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
abstract class Rule{

    private $match;

    /**
     * @var mixed|null
     */
    private $token;

    /**
     * @var int
     */
    private $priority;

    /**
     * @var mixed[]
     */
    private $options;

    /**
     * Constructor
     *
     * @param   string  $match
     *      一致判定用の文字列を指定する。この文字列の使い方はそれぞれのルールに
     *      一任される。なのでオブジェクトをシリアライズした文字を要求してもよい。
     * @param   mixed   $token  [optional]
     *      トークン識別子を指定する。nullが指定された場合はスキップされる。
     * @param   int $priority   [optional]
     *      ルールの優先度を指定する。複数のルールが同時に一致した場合に、
     *      最も優先度の高いルールが適用される。ただし優先度も同じ場合は最も
     *      一致文字列長が長いものが適用される。
     * @param   mixed[] $options    [optional]
     *      ルール固有のオプションを指定する。
     */
    public function __construct(
        string $match,
        $token = null,
        int $priority = 0,
        array $options = []
    ){
        $this->match    = $match;
        $this->token    = $token;
        $this->priority = $priority;
        $this->options  = $options;
    }

    /**
     * 一致文字列を返す
     *
     * @return  string
     */
    public function getMatch(){
        return $this->match;
    }

    /**
     * トークンを取得する
     *
     * @return  mixed|null
     */
    public function getToken(){
        return $this->token;
    }

    /**
     * 優先度を取得する
     *
     * @return  int
     */
    public function getPriority(){
        return $this->priority;
    }

    /**
     * オプションリストを取得する
     *
     * @return  mixed[]
     */
    public function getOptions(){
        return $this->options;
    }

    /**
     * 指定した名前のオプションを取得する
     *
     * オプションが存在しなければnullを返す。
     *
     * @param   string  $key
     *
     * @return  mixed|null
     */
    public function getOption(string $key){
        return $this->options[$key] ?? null;
    }

    /**
     * 先頭から何文字がこのルールにマッチしたか返す
     *
     * @param   string  $string
     *
     * @return  int
     */
    abstract public function matchedLength(string $string): int;
}