<html>
<head>
    
    
    </head>

<body>
    <?php
    include "function/configuration.php";

    //pendevinisian variabel
    $sistole = $_POST["tds"];
    $diastole = $_POST["tdd"];
    $guldar = $_POST["guldar"];
    $riwayat = $_POST["riwayatkeluarga"];
    $perokok = $_POST["perokok"];
    $kol = $_POST["kolesterol"];
    $aktivitas_fisik = $_POST["aktivitas_fisik"];
    $tb = $_POST["tb"];
    $bb = $_POST["bb"];
    $fibrilasi_atrium = $_POST["fibrilasi_atrium"];
	
    //method tekanan darah
    function tekanandarah($sistole, $diastole){
		$results1	= mysql_query ("select * from penentuan_td where aturan_td = 'S1'");
		$datas1 = mysql_fetch_array ($results1);
		$results2	= mysql_query ("select * from penentuan_td where aturan_td = 'S2'");
		$datas2 = mysql_fetch_array ($results2);
		$results3	= mysql_query ("select * from penentuan_td where aturan_td = 'S3'");
		$datas3 = mysql_fetch_array ($results3);
		$resultd1	= mysql_query ("select * from penentuan_td where aturan_td = 'D1'");
		$datad1 = mysql_fetch_array ($resultd1);
		$resultd2	= mysql_query ("select * from penentuan_td where aturan_td = 'D2'");
		$datad2 = mysql_fetch_array ($resultd2);
		$resultd3	= mysql_query ("select * from penentuan_td where aturan_td = 'D3'");
		$datad3 = mysql_fetch_array ($resultd3);
		
        $nilai = 0;
				if($sistole>$datas1['range_bawah'] AND ($diastole>$datad1['range_bawah'] OR ($diastole>=$datad2['range_bawah'] AND $diastole<=$datad2['range_atas']) OR $diastole<$datad3['range_atas'])){
					$nilai = $datas1['idgejala']; 
				return $nilai;
				}
				if(($sistole>=$datas2['range_bawah'] AND $sistole<=$datas2['range_atas']) AND (($diastole>=$datad2['range_bawah'] AND $diastole<=$datad2['range_atas']) OR $diastole<$datad3['range_atas'])){
					$nilai = $datas2['idgejala']; 
				return $nilai;
				}
				if($sistole<$datas3['range_atas'] AND $diastole<$datad3['range_atas'] AND $sistole>0 AND $diastole>0){
					$nilai = $datas3['idgejala']; 
				return $nilai;
				}
				if($diastole>$datad1['range_bawah'] AND (($sistole>=$datas2['range_bawah'] AND $sistole<=$datas2['range_atas']) OR $sistole<$datas3['range_atas'])){
					$nilai = $datad1['idgejala']; 
				return $nilai;
				}
				if(($diastole>=$datad2['range_bawah'] AND $diastole<=$datad2['range_atas']) AND $sistole<$datas3['range_atas']){
					$nilai = $datad2['idgejala']; 
				return $nilai;
				}
    }
        
     function guladarah($guldar){
		$resultguldar1	= mysql_query ("select * from faktor_resiko where idgejala = '004'");
		$dataguldar1 = mysql_fetch_array ($resultguldar1);
		$resultguldar2	= mysql_query ("select * from faktor_resiko where idgejala = '005'");
		$dataguldar2 = mysql_fetch_array ($resultguldar2);
		$resultguldar3	= mysql_query ("select * from faktor_resiko where idgejala = '006'");
		$dataguldar3 = mysql_fetch_array ($resultguldar3);
		
		$nilai2 = 0;
        if($guldar>$dataguldar1['range_bawah']){
            $nilai2 = $dataguldar1['idgejala']; 
        return $nilai2;
		}
        if($guldar>=$dataguldar2['range_bawah'] AND $guldar<=$dataguldar2['range_atas'] ){
        $nilai2 = $dataguldar2['idgejala'];
            return $nilai2;
        }
        if($guldar<$dataguldar3['range_atas'] AND $guldar>0){
        $nilai2 = $dataguldar3['idgejala'];
            return $nilai2;
        }
    }

     function kol($kol){
		$resultkol1	= mysql_query ("select * from faktor_resiko where idgejala = '013'");
		$datakol1 = mysql_fetch_array ($resultkol1);
		$resultkol2	= mysql_query ("select * from faktor_resiko where idgejala = '014'");
		$datakol2 = mysql_fetch_array ($resultkol2);
		$resultkol3	= mysql_query ("select * from faktor_resiko where idgejala = '015'");
		$datakol3 = mysql_fetch_array ($resultkol3);
		
		$nilai3 = 0;
        if($kol>$datakol1['range_bawah']){
            $nilai3 = $datakol1['idgejala']; 
        return $nilai3;
		}
        if($kol>=$datakol2['range_bawah'] AND $kol<=$datakol2['range_atas'] ){
        $nilai3 = $datakol2['idgejala'];
            return $nilai3;
        }
        if($kol<$datakol3['range_atas'] AND $kol>0){
        $nilai3 = $datakol3['idgejala'];
            return $nilai3;
        }
    }

     function diet($tb,$bb){
		$resultdiet1	= mysql_query ("select * from faktor_resiko where idgejala = '019'");
		$datadiet1 = mysql_fetch_array ($resultdiet1);
		$resultdiet2	= mysql_query ("select * from faktor_resiko where idgejala = '020'");
		$datadiet2 = mysql_fetch_array ($resultdiet2);
		$resultdiet3	= mysql_query ("select * from faktor_resiko where idgejala = '021'");
		$datadiet3 = mysql_fetch_array ($resultdiet3);
		
			$nilai4 = 0;
		    $tb = $tb/100;
			$tb2 = $tb*$tb;
			if ($tb2 == 0) {
				$IMT = "";
			} else {
				$IMT = $bb/$tb2;
				if($bb == 'null' || tb == 'null'){
						$nilai4 = ""; 
					return $nilai4;
				}
				else if ($tb != 'null' || tb != 'null')
				{
					if($IMT>$datadiet1['range_bawah']){
						$nilai4 = $datadiet1['idgejala']; 
					return $nilai4;
					}
					if($IMT>=$datadiet2['range_bawah'] AND $IMT<=$datadiet2['range_atas'] ){
					$nilai4 = $datadiet2['idgejala'];
						return $nilai4;
					}
					if($IMT<$datadiet3['range_atas']){
					$nilai4 = $datadiet3['idgejala'];
						return $nilai4;
					}
				}
		}
    }



//Hasil Klasifikais Tingkat Gejala 
$tekanan_darah = tekanandarah($sistole,$diastole);
$diabetes = guladarah($guldar);
$kolesterol = kol($kol);
$diet =  diet($tb,$bb);


//TES
/*echo $tekanan_darah;
echo $fibrilasi_atrium;
echo $perokok;
echo $kolesterol;
echo $diabetes;
echo $aktivitas_fisik;
echo $diet;
echo $riwayat;
*/

$hasil = $tekanan_darah.$fibrilasi_atrium.$perokok.$kolesterol.$diabetes.$aktivitas_fisik.$diet.$riwayat;
$deteksifaktor = array($tekanan_darah,$fibrilasi_atrium,$perokok,$kolesterol,$diabetes,$aktivitas_fisik,$diet,$riwayat);


echo $hasil;
echo array_filter($deteksifaktor);
echo "<br>";
$hitungfaktor = count(array_filter($deteksifaktor));
echo $hitungfaktor;
echo "<br>";

function returnsame($array1,$array2){
    $temp = array();
    $len1 = count($array1);
    $len2 = count($array2);
    if($len2 != $len1){
        if($len1 > $len2){
            $result = array_diff($array1, $array2);
            foreach($array1 as $val){
                if(!in_array($val,$result)){
                    $temp[]=$val;
                }
            }
        }else{
            $result = array_diff($array2, $array1);
            foreach($array2 as $val){
                if(!in_array($val,$result)){
                    $temp[]=$val;
                }
            }
        }
        $result = $temp;
    }else{
        $result = $array1;
    }
    return $result;
}


	$combine = array();
    $densitas = 0;
    if($hitungfaktor>1){
        echo "ada banyak";
		
		$cnt = 1;
        $length = $hitungfaktor;
        foreach(array_filter($deteksifaktor) as $key=>$val){
            $query = "select * from faktor_resiko where idgejala='".$val."'";
			$res = mysql_query($query);
            $gejala = mysql_fetch_assoc($res);

            $text ="<br><br> Gejala ".($key+1)." : ".$gejala['tingkat_faktor_resiko'];
			
			//echo $text;
			//echo "$query";
			//echo "kodegejala = $val";
			
			//list penyakit yang memiliki gejala bersangkutan
            $que="select a.*,p.nama,count(a.idgejala) as jumlah,sum(CAST(a.densitas AS DECIMAL(10,2))) as jumdens from aturan a left join faktor_resiko g on g.idgejala=a.idgejala left join resiko_stroke p on p.idpenyakit=a.idpenyakit where a.idgejala  = '$val' group by a.idpenyakit order by nama desc,jumdens desc";
			//echo $que;
			
            $res=mysql_query($que);
            while($row=mysql_fetch_assoc($res)){
                $penyakit[]=$row['nama'];
                $idpenyakit[]=$row['idpenyakit'];
                if($row['densitas']>$densitas)$densitas=$row['densitas'];
            }

            $combine[$cnt]['idpenyakit'] = implode(',',$idpenyakit);
            $combine[$cnt]['densitas']['id'] = $idpenyakit;
            $combine[$cnt]['densitas']['value'] = $densitas;
            $combine[$cnt]['teta']['id'] = 'teta';
            $combine[$cnt]['teta']['value'] = 1 - $densitas;

            //penyakit
            $tempc['id']=$idpenyakit;
            $tempc['value']=$densitas;
            $tempcombine[$cnt][]=$tempc;

            //teta
            $tempc['id']=array('teta');
            $tempc['value']=1-$densitas;
            $tempcombine[$cnt][]=$tempc;


            $text .="<br> Penyakit yang memungkinkan yaitu ".implode(',',$penyakit)." .";
            $text .="<br> m".$cnt."{".implode(',',$penyakit)."} = ".$densitas;
            $text .="<br> m".$cnt."{teta} = ".(1-$densitas);
			
			echo $text;
			
			
			            if($cnt==1){
                $tempid[]=$idpenyakit;
                $tempid[]=array('teta');
                $tempdens[]=$densitas;
                $tempdens[]=1-$densitas;
            }

            if($cnt>1){
                $text.="<br> Hitungan kombinasi m".($cnt+1);

                //hitung kombinasi

                //temp kombinasi
                $zzz = count($tempid);
                for($itung=0;$itung<$zzz;$itung++){
                    for($itg=0;$itg<2;$itg++){
                        if(!in_array('teta',$tempcombine[$cnt][$itg]['id']) && !in_array('teta',$tempid[$itung])){
                            $tempid[] = returnsame($tempid[$itung],$tempcombine[$cnt][$itg]['id']);
                            $tttt[$cnt][] = returnsame($tempid[$itung],$tempcombine[$cnt][$itg]['id']);
                        }else{
                            if(in_array('teta',$tempcombine[$cnt][$itg]['id'])){
                                $tempid[] = $tempid[$itung];
                                $tttt[$cnt][] = $tempid[$itung];
                            }else{
                                $tempid[] = $tempcombine[$cnt][$itg]['id'];
                                $tttt[$cnt][] = $tempcombine[$cnt][$itg]['id'];
                            }
                        }
                        $tempdens[] = $tempdens[$itung] * $tempcombine[$cnt][$itg]['value'];
                        $aaa[$cnt][] = $tempdens[$itung] * $tempcombine[$cnt][$itg]['value'];

                        /*if($cnt==4){
                            echo $tempdens[$itung]."*".$tempcombine[$cnt][$itg]['value'];
                            echo "<br>";
                            var_dump(json_encode($tempcombine));
                        }*/
                    }
                }


                //rearray $tttt
                foreach($tttt as $k=>$v){
                       foreach($v as $r){
                           sort($r);
                           $t[$k][implode(',',$r)]=$r;
                       }
                }
                $tttt = $t;

                for($itung=0;$itung<$zzz;$itung++){
                    unset($tempid[$itung]);
                    unset($tempdens[$itung]);
                }
                $tempid=array_values($tempid);
                $tempdens=array_values($tempdens);

                //sorting
                for($itung=0;$itung<count($tempid);$itung++){
                    sort($tempid[$itung]);
                }

                //group
                for($itung=0;$itung<count($tempid);$itung++){
                    $tempo[implode(',',$tempid[$itung])][]=$tempdens[$itung];
                }

                //rearrange array
                foreach($tempo as $k=>$v){
                    $jumlah = 0;
                    $temporaryid [] = explode(',',$k);
                    foreach($v as $row){
                        $jumlah = $jumlah + $row;
                    }
                    $temporarydens [] = $jumlah ;
                    $zzzz[$cnt][] = $jumlah;
                }

                $tempid = $temporaryid;
                $tempdens = $temporarydens;
              
                //get max densitas
                $maxxx = 0;
                $idp = 0;
                foreach($tempdens as $k=>$r){
                        if($r>$maxxx)
                        {
                            $maxxx=$r;
                            $idp=$k;
                        }
                }

                //get teta
                foreach($tempid as $k=>$v){
                    if(in_array('teta',$v)){
                        $idxteta = $k;
                    }
                }

                //hasil diagnosa penyakit
                if($length == $key+1){
                    $idhasilpenyakit = $tempid[$idp];
                }

                //tabel kombinasi

                $text.="<table cellpadding='0' id='tSortable_2' cellspacing='0' width='100%' class='table'>";
                $text.= "<tr>";
                $text.= "<td width='25%'>&nbsp;</td>";
                $text.= "<td width='37%'>{".implode(',',$tempcombine[$cnt][0]['id'])."}".$tempcombine[$cnt][0]['value']."</td>";
                $text.= "<td width='37%'>{".implode(',',$tempcombine[$cnt][1]['id'])."}".$tempcombine[$cnt][1]['value']."</td>";
                $text.= "</tr>";
                $text.= "<tr>";
                $text.= "<td colspan='3'>";

                $aaa[$cnt] = array_chunk($aaa[$cnt],2);
                $xyz = 0;
                $i = $j = 0;

                $text.="<table cellpadding='0' id='tSortable_2' cellspacing='0' width='100%' class='table'>";
                $text.= "<tr>";
                $text.= "<td width='24.5%'>";
                $text.="<table cellpadding='0' id='tSortable_2' cellspacing='0' width='100%' class='table'>";

                if($cnt>2){
                foreach($tttt[$cnt-1] as $y=>$r){
                    $text.= "<tr>";
                    $text.="<td>{".$y."}".$zzzz[$cnt-1][$xyz]."</td>";
                    $text.= "</tr>";
                    $xyz++;
                }
                }else{
                    foreach($tempcombine[$cnt-1] as $g){
                        $text.= "<tr>";
                        $text.="<td>{".implode(',',$g['id'])."}".$g['value']."</td>";
                        $text.= "</tr>";
                    }
                }

                $text.= "</table>";
                $text.= "</td>";
                $text.= "<td colspan='2'>";
                $text.="<table cellpadding='0' id='tSortable_2' cellspacing='0' width='100%' class='table'>";
                foreach($aaa[$cnt] as $x){
                    $text.= "<tr>";
                    foreach($x as $k=>$v){
                        $text.="<td width='37%'>".$v."</td>";
                    }
                    $text.= "</tr>";
                }
                $text.="</table>";

                $text.= "</td>";
                $text.= "</tr>";
                $text.= "</table>";
                $text.= "</td>";
                $text.= "</tr>";
                $text.= "</table>";

                $text .="<br> m".($cnt+1)."{".implode(',',$tempid[$idp])."} = ".$maxxx;
                $text .="<br> m".($cnt+1)."{teta} = ".$tempdens[$idxteta];
            }

            $penyakit = array();
            $idpenyakit = array();
            $tempteta = $temporaryid = $temporarydens = $tempo = array();
//            $tempteta = $tempdens = $tempid = array();
            $densitas = 0;
            $cnt++;
        }

        $idhasilpenyakit = "'".implode("','",$idhasilpenyakit)."'";
        $que = "select * from resiko_stroke where idpenyakit in (".$idhasilpenyakit.")";
		$result = mysql_query($que);
        while($row = mysql_fetch_array($que)){
            $nmpeny [] = $row['nama'];
        }
			echo $que;

        $text .= "<br><br> Hasil diagnosa mendekati penyakit ".implode(',',$nmpeny);

			echo $text;

            
    }
	elseif($hitungfaktor==1)
	{
       echo "cuma 1";

    }



/*    //dempster shafer
	if($_REQUEST['act']=='add'){
    //var_dump($_REQUEST);die;
    $arrgejala = substr($_REQUEST['arraygejala'], 0, -1);

    $arrgejala = explode(',',$arrgejala);

    $text ="<br> Nama Pengguna : ".$_SESSION['logged_in_user'];
    $text .="<br> Tanggal Diagnosa : ".date('d-m-Y')." <br>";

    $combine = array();
    $densitas = 0;

    if(count($arrgejala)>1){
        
    }
	elseif(count($arrgejala)==1)
	{
       

    }
*/

    

    ?>
    
    
    </body>
</html>