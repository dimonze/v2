<?php

/**
 * Porter`s stemmer. PHP realization by Dmitriy Koterov.
 */
class Analysis_StemmerRu extends Zend_Search_Lucene_Analysis_TokenFilter
{
  private
    $stem_caching = 0,
    $stem_cache   = array(),
    $perfectiveground = '/((ив|ивши|ившись|ыв|ывши|ывшись)|((?<=[ая])(в|вши|вшись)))$/iu',
    $reflexive  = '/(с[яь])$/iu',
    $adjective  = '/(ее|ие|ые|ое|ими|ыми|ей|ий|ый|ой|ем|им|ым|ом|его|ого|ему|ому|их|ых|ую|юю|ая|яя|ою|ею)$/iu',
    $participle = '/((ивш|ывш|ующ)|((?<=[ая])(ем|нн|вш|ющ|щ)))$/iu',
    $verb = '/((ила|ыла|ена|ейте|уйте|ите|или|ыли|ей|уй|ил|ыл|им|ым|ен|ило|ыло|ено|ят|ует|уют|ит|ыт|ены|ить|ыть|ишь|ую|ю)|((?<=[ая])(ла|на|ете|йте|ли|й|л|ем|н|ло|но|ет|ют|ны|ть|ешь|нно)))$/iu',
    $noun = '/(а|ева|ев|ова|ов|ие|ье|е|иями|ями|ами|еи|ии|и|ией|ей|ой|ий|й|иям|яма|ям|иема|ием|ема|ем|ама|ам|ом|ома|о|у|ах|иях|ях|ы|ь|ию|ью|ю|ия|ья|я)$/iu',
    $rvre = '/^(.*?[аеиоуыэюя])(.*)$/iu',
    $derivational = '/[^аеиоуыэюя][аеиоуыэюя]+[^аеиоуыэюя]+[аеиоуыэюя].*(?<=о)сть?$/iu';

  /**
   * Constructs new instance of this filter.
   */
  public function __construct()
  {
  }

  /**
   * Stem Token or remove it (if null is returned)
   *
   * @param Zend_Search_Lucene_Analysis_Token $srcToken
   * @return Zend_Search_Lucene_Analysis_Token
   */
  public function normalize(Zend_Search_Lucene_Analysis_Token $srcToken)
  {
    $stemmed_word = $this->stem($srcToken->getTermText());
    if (mb_strlen($stemmed_word) < 3) return $srcToken;
    
    $newToken = new Zend_Search_Lucene_Analysis_Token(
      $stemmed_word,
      $srcToken->getStartOffset(),
      $srcToken->getEndOffset()
    );
    $newToken->setPositionIncrement($srcToken->getPositionIncrement());
    
    return $newToken;
  }

  public function stem($word)
  {
    if ($this->stem_caching && isset($this->stem_cache[$word])) {
      return $this->stem_cache[$word];
    }

    $stem = $word;
    do {
      if (!preg_match($this->rvre, $word, $p)) break;
      $start = $p[1];
      $rv = $p[2];
      if (!$rv) break;

      if (!$this->s($rv, $this->perfectiveground, '')) {
        $this->s($rv, $this->reflexive, '');

        if ($this->s($rv, $this->adjective, '')) {
          $this->s($rv, $this->participle, '');
        } else {
          if (!$this->s($rv, $this->verb, ''))
            $this->s($rv, $this->noun, '');
        }
      }

      $this->s($rv, '/и$/iu', '');

      if ($this->m($rv, $this->derivational))
        $this->s($rv, '/ость?$/iu', '');

      if (!$this->s($rv, '/ь$/iu', '')) {
        $this->s($rv, '/ейше?/iu', '');
        $this->s($rv, '/нн$/iu', 'н');
      }

      $stem = $start.$rv;
    } while(false);

    if ($this->stem_caching) $this->stem_cache[$word] = $stem;

    return $stem;
  }

  public function stem_caching($parm_ref)
  {
    $caching_level = @$parm_ref['-level'];
    if ($caching_level) {
      if (!$this->m($caching_level, '/^[012]$/')) {
        die(__CLASS__ . "::stem_caching() - Legal values are '0','1' or '2'. '$caching_level' is not a legal value");
      }
      $this->stem_caching = $caching_level;
    }

    return $this->stem_caching;
  }

  public function clear_stem_cache()
  {
    $this->stem_cache = array();
  }


  private function s(&$s, $re, $to)
  {
    $orig = $s;
    $s = preg_replace($re, $to, $s);
    return $orig !== $s;
  }

  private function m($s, $re)
  {
    return preg_match($re, $s);
  }
}