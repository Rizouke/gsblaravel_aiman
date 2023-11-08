<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PdoGsb;

class connexionController extends Controller
{
    function connecter(){

        return view('connexion')->with('erreurs',null);
    }
    function valider(Request $request){
        $login = $request['login'];
        $mdp = $request['mdp'];
        $visiteur = PdoGsb::getInfosVisiteur($login,$mdp);
        $comptable= PdoGsb::getComptable($login,$mdp);
        if(!is_array($visiteur) && !is_array($comptable)){
            $erreurs[] = "Login ou mot de passe incorrect(s)";
            return view('connexion')->with('erreurs',$erreurs);
        }
        else if(is_array($visiteur) && !is_array($comptable)){
            session(['visiteur' => $visiteur]);
            return view('sommaire')->with('visiteur',session('visiteur'));

        }
        else if(is_array($comptable) && !is_array($visiteur)){
            session(['comptable' => $comptable]);
            return view('sommaire')->with('comptable',session('comptable'));
        }
    }
    function deconnecter(){
            session(['visiteur' => null]);
            return redirect()->route('chemin_connexion');


    }

}
