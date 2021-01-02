<?php
require_once '../cdp/Encode.php';
include_once('./Model/RiskAnswers.php');
//$userData = getUserData($_REQUEST); //answersの取得

function getChartData($userData){
	//DBの接続情報
	require_once '../cdp/DbManager.php';

	//DBコネクタを生成
    $db=getDb();
    $impact_figure=[];
    foreach($userData as $row){
        $sql=$db->prepare('SELECT figure FROM impacts where term_by_cdp=:impact');
        $impact=strval($row['Magnitude_of_impact']);
        $sql->bindvalue(":impact",$impact,PDO::PARAM_STR);
        $sql->execute();
        $impact_figure[]=$sql->fetch(PDO::FETCH_ASSOC);

        
    }
    $likelihood_figure=[];
    foreach($userData as $row){
        $sql=$db->prepare('SELECT figure FROM likelihoods where term_by_cdp=:likelihood');
        $likelihood=strval($row['Likelihood']);
        $sql->bindvalue(":likelihood",$likelihood,PDO::PARAM_STR);
        $sql->execute();
        $likelihood_figure[]=$sql->fetch(PDO::FETCH_ASSOC);
    }
       
    $tmhz_figure=[];
    foreach($userData as $row){

        $sql=$db->prepare('SELECT figure FROM time_horizons where term_by_cdp=:time_horizon');
        $time_horizon=strval($row['time_horizon']);
        $sql->bindvalue(":time_horizon",$time_horizon,PDO::PARAM_STR);
        $sql->execute();
        $tmhz_figure[]=$sql->fetch(PDO::FETCH_ASSOC);
    }


    $result =array($impact_figure,$likelihood_figure,$tmhz_figure);
    

    return $result;
}

