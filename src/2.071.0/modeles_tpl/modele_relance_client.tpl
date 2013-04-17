Madame, Monsieur,<BR/>
<BR/>
Sauf erreur ou omission de notre part, nous constatons que votre compte client pr&eacute;sente &agrave; ce jour un solde d&eacute;biteur de {SOLDECOMPTABLE:} .<BR/>
<BR/>
Ce montant correspond &agrave; nos factures suivantes rest&eacute;es impay&eacute;es :<BR/><BR/>
{BLOCK:factures_relance}
- Facture n° {DATA:factures_relance.ref_doc} du {DATA:factures_relance.date} : {DATA:factures_relance.type_echeance} de {DATA:factures_relance.montant_echeance} d&ucirc; au {DATA:factures_relance.date_echeance}<BR/>
{BLOCKEND:factures_relance}
<BR/>
<BR/>
L&apos;&eacute;ch&eacute;ance &eacute;tant d&eacute;pass&eacute;e, nous vous demandons de bien vouloir r&eacute;gulariser cette situation dans les plus brefs d&eacute;lais.<BR/>
Dans le cas o&ugrave; votre r&egrave;glement aurait &eacute;t&eacute; adress&eacute; entre temps, nous vous prions de ne pas tenir compte de la pr&eacute;sente lettre.<BR/>
<BR/>


Vous remerciant de votre diligence, nous vous prions d'agr&eacute;er, Madame, Monsieur, l&apos;expression de nos salutations distingu&eacute;es.<BR/>
<BR/>

{TPLINCLUDE:signature_collab.tpl}