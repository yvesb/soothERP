<?php

//	Ceci est une librairie.
//
//	Elle se materialise sous forme de classe pour plusieurs raisons :
//		- pour délimiter une nom de dommaine
//		- pour pouvoir avoir des définir des fonctions communes à tous les e-commerces
//			et d'autres spécifiques à un seul.
//		- de cette manière, nous pouvons aussi 'masquer' les fonctions dans les sous classe
//			(c'est une sorte de redéfinition)
//	Il est à noter que :  
//		-	TOUTES les fonctions de cette classes et de ses sous classes doivent être STATIC.
//		-	Cette classes et ses sous classes DOIVENT être abstraites 
//
//	E_commerce_Lib <: Profil_client_Lib			La librairie Profil_client_Lib est sous classe de E_commerce_Lib
//																					et est propre à l'e-commerce profil client
//
//	E_commerce_Lib <: E_commerce_Toto_Lib		La librairie E_commerce_Toto_Lib est sous classe de E_commerce_Lib
//																					et est propre à l'e-commerce Toto
//
//
abstract class E_commerce_Lib{
	
}