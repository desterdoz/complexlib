<?php

  class stringparse
  {
    public $r = [];
    public function parse($instring)
    {
      $m = explode('+',str_replace('-','+-',$instring));
      if (count($m) == 3) {
        $this->r = [$m[1],$m[2]];
      } else {
        $this->r = $m;
      }
    }
  }

  class Complex extends stringparse
  {
    public function cxSumm($arrofmemb) {
      $a1=0;$a2=0;
      foreach ($arrofmemb as $v) {
        $this->parse($v);
        if (strpos($this->r[0],'i') === false){
          $a1 += $this->r[0]*1;
          $a2 += str_replace('i','',$this->r[1])*1;
        } else {
          $a1 += $this->r[1]*1;
          $a2 += str_replace('i','',$this->r[0])*1;
        }
      }
      return $a1.($a2>0?'+':'').$a2.'i';

    }
    public function cxSubtr($arrofmemb) {
      $this->parse($arrofmemb[0]);
      if (strpos($this->r[0],'i') === false){
        $a1 = $this->r[0]*1;
        $a2 = str_replace('i','',$this->r[1])*1;
      } else {
        $a1 = $this->r[1]*1;
        $a2 = str_replace('i','',$this->r[0])*1;
      }
      unset($arrofmemb[0]);

      foreach ($arrofmemb as $v) {
        $this->parse($v);
        if (strpos($this->r[0],'i') === false){
          $a1 -= $this->r[0]*1;
          $a2 -= str_replace('i','',$this->r[1])*1;
        } else {
          $a1 -= $this->r[1]*1;
          $a2 -= str_replace('i','',$this->r[0])*1;
        }
      }
      return $a1.($a2>0?'+':'').$a2.'i';
    }
    public function cxMult($arrofmemb) {
      $a1 = 1; $a2 = 0;
      foreach ($arrofmemb as $v) {
        $this->parse($v);
        if (strpos($this->r[0],'i') === false){
          $t1 = 0; $t2 = 1;
        } else {
          $t1 = 1; $t2 = 0;
        }
        $a1t = $a1 * $this->r[$t1]*1 - $a2*str_replace('i','',$this->r[$t2])*1;
        $a2t = $a1 * str_replace('i','',$this->r[$t2])*1 + $a2 * $this->r[$t1]*1;
        $a1 = $a1t;$a2 = $a2t;
      }
      return $a1.($a2>0?'+':'').$a2.'i';
    }
    public function cxDiv($arrofmemb) {
      $this->parse($arrofmemb[0]);
      if (strpos($this->r[0],'i') === false){
        $a1 = $this->r[0]*1;
        $a2 = str_replace('i','',$this->r[1])*1;
      } else {
        $a1 = $this->r[1]*1;
        $a2 = str_replace('i','',$this->r[0])*1;
      }
      unset($arrofmemb[0]);
      foreach ($arrofmemb as $v) {
        $this->parse($v);
        if (strpos($this->r[0],'i') === false){
          $t1 = 0; $t2 = 1;
        } else {
          $t1 = 1; $t2 = 0;
        }
        $a1t = ($a1 * $this->r[$t1]*1 + $a2 * str_replace('i','',$this->r[$t2])*1)/($this->r[$t1]*1 * $this->r[$t1]*1 + str_replace('i','',$this->r[$t2])*1 * str_replace('i','',$this->r[$t2])*1);
        $a2t = ($a2 * $this->r[$t1]*1 - $a1 * str_replace('i','',$this->r[$t2])*1)/($this->r[$t1]*1 * $this->r[$t1]*1 + str_replace('i','',$this->r[$t2])*1 * str_replace('i','',$this->r[$t2])*1);
        $a1 = $a1t;$a2 = $a2t;
      }
      return $a1.($a2>0?'+':'').$a2.'i';
    }

  }

  echo "<textarea cols='100' rows='15'>";
  $a = new Complex;
  print_r($a->cxSumm(['2-3i','+5-3i','-7-5i','-11+14i','+11+20i']));
  echo PHP_EOL;
  print_r($a->cxSubtr(['2-3i','+5-3i','-7-5i','-11+14i','+11+20i']));
  echo PHP_EOL;
  print_r($a->cxMult(['2-2i','-1.6-0.2i']));
  echo PHP_EOL;
  print_r($a->cxDiv(['-3.6+2.8i','-1.6-0.2i']));
  echo "</textarea>";
?>
