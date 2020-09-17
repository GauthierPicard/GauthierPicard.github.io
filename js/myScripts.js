<!--
      var numLogos    = 0;
		 var numRien     = 1;
		 var numMenu     = 0;
		 var numActivite = 2;
		 var numExemple  = 3;

   function chargerCadres (nbCadres, tabNumCadres, tabUrlCadres) {
   //----------------------------------------------------------------
   	for (i = 0; i < nbCadres; i++)  {
		  parent.frames[tabNumCadres[i]].location.href = tabUrlCadres[i];
		}
   }
		
   // Chargement Menu, Description générale et Aide au chargement menu
	function chargerCadre3 (nomPage1, nomPage2, nomPage3) {
	//-----------------------------------------------------
   	var tabNoms = new Array(3);
   	tabNoms[0] = nomPage1;
   	tabNoms[1] = nomPage2;
	  tabNoms[2] = nomPage3;

		var tabNums = new Array(3);
		tabNums[0] = numMenu;
		tabNums[1] = numActivite;
		tabNums[2] = numExemple;

		chargerCadres (3,tabNums,tabNoms);
	}

	// Chargement 2 pages : une dans cadre Activite, l'autre dans cadre Exemple
	// Paramètres: nom répertoire page 1, nom page 1
	//             nom répertoire page 2, nom page 2

	function chargerActiviteExemple (nomPageActivite, nomPageExemple) {
	//----------------------------------------------------------------------------------------------
	  var tabNoms = new Array(2);
		tabNoms[0] = nomPageActivite;
		tabNoms[1] = nomPageExemple;

		var tabNums = new Array(2);
		tabNums[0] = numActivite;
		tabNums[1] = numExemple;

		chargerCadres (2,tabNums,tabNoms);
		}

	//-->
	
	function generate(size) {
m = "";
a = "a";
codeA = a.charCodeAt(0);
for(k = 0; k < size; k++) {
c = String.fromCharCode(codeA + Math.floor(Math.random() * 26));
m += c;
}
return m;
}
function killBot(_this) {
_this.innerHTML = generate(8) + '@' + generate(5) + '.com';
killBot();
}
function printMail(_this, fake, validity) {
m = "";
for(k = 0; k < fake.length; k+=validity) {
c = fake.charAt(k);
if(c == '#') c = '@';
m += c;
}
_this.innerHTML = m;
_this.href = "mailto:"+m;
}

function printMailTo(_this, fake, subject, validity) {
m = "";
for(k = 0; k < fake.length; k+=validity) {
c = fake.charAt(k);
if(c == '#') c = '@';
m += c;
}
_this.innerHTML = m;
_this.href = "mailto:"+m+"?subject="+subject;
}