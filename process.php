<?php
/*
 * @author Balaji
 */
error_reporting(1);

$data_host = htmlentities(Trim($_POST['data_host']));
$data_name = htmlentities(Trim($_POST['data_name']));
$data_user = htmlentities(Trim($_POST['data_user']));
$data_pass = htmlentities(Trim($_POST['data_pass']));
$data_sec = htmlentities(Trim($_POST['data_sec']));


$con = mysqli_connect($data_host,$data_user,$data_pass,$data_name);

if (mysqli_connect_errno())
{
echo "0";
goto fx;
}


$data = '<?php
/*
 * @author Balaji
 */
error_reporting(1);

// MySQL Hostname
$mysql_host = "'.$data_host.'";

// MySQL Username
$mysql_user = "'.$data_user.'";

// MySQL Password
$mysql_pass = "'.$data_pass.'";

// MySQL Database Name
$mysql_database = "'.$data_name.'";'."

//Encryption secret key".'
$sec_key'." = '$data_sec';
define('SECRET',md5(".'$sec_key));

//mod_rewrite
$mod_rewrite = "1";


//Oauth Services

// Facebook
define(\'FB_APP_ID\', \' \');   // Enter your facebook application id
define(\'FB_APP_SECRET\', \' \');    // Enter your facebook application secret code
define(\'FB_Redirect_Uri\', \'http://' . $_SERVER['HTTP_HOST'] .'/oauth/facebook.php\');

// Google 
define(\'G_Client_ID\', \' \');  // Enter your google api application id
define(\'G_Client_Secret\', \' \'); // Enter your google api application secret code
define(\'G_Redirect_Uri\', \'http://' . $_SERVER['HTTP_HOST'] .'/oauth/google.php\');
define(\'G_Application_Name\', \'MyPasteBox\');


// Available GeSHi formats
$geshiformats =array('."
	'4cs'=>'GADV 4CS',
	'6502acme'=>'ACME Cross Assembler',
	'6502kickass'=>'Kick Assembler',
	'6502tasm'=>'TASM/64TASS 1.46',
	'68000devpac'=>'HiSoft Devpac ST 2',
	'abap'=>'ABAP',
	'actionscript'=>'ActionScript',
	'actionscript3'=>'ActionScript 3',
	'ada'=>'Ada',
	'aimms'=>'AIMMS3',
	'algol68'=>'ALGOL 68',
	'apache'=>'Apache',
	'applescript'=>'AppleScript',
	'arm'=>'ARM Assembler',
	'asm'=>'ASM',
	'asp'=>'ASP',
	'asymptote'=>'Asymptote',
	'autoconf'=>'Autoconf',
	'autohotkey'=>'Autohotkey',
	'autoit'=>'AutoIt',
	'avisynth'=>'AviSynth',
	'awk'=>'Awk',
	'bascomavr'=>'BASCOM AVR',
	'bash'=>'BASH',
	'basic4gl'=>'Basic4GL',
	'bf'=>'Brainfuck',
	'bibtex'=>'BibTeX',
	'blitzbasic'=>'BlitzBasic',
	'bnf'=>'BNF',
	'boo'=>'Boo',
	'c'=>'C',
	'c_loadrunner'=>'C (LoadRunner)',
	'c_mac'=>'C for Macs',
	'c_winapi'=>'C (WinAPI)',
	'caddcl'=>'CAD DCL',
	'cadlisp'=>'CAD Lisp',
	'cfdg'=>'CFDG',
	'cfm'=>'ColdFusion',
	'chaiscript'=>'ChaiScript',
	'chapel'=>'Chapel',
	'cil'=>'CIL',
	'clojure'=>'Clojure',
	'cmake'=>'CMake',
	'cobol'=>'COBOL',
	'coffeescript'=>'CoffeeScript',
	'cpp'=>'C++',
	'cpp-qt'=>'C++ (with QT extensions)',
	'cpp-winapi'=>'C++ (WinAPI)',
	'csharp'=>'C#',
	'css'=>'CSS',
	'cuesheet'=>'Cuesheet',
	'd'=>'D',
	'dcl'=>'DCL',
	'dcpu16'=>'DCPU-16 Assembly',
	'dcs'=>'DCS',
	'delphi'=>'Delphi',
	'diff'=>'Diff-output',
	'div'=>'DIV',
	'dos'=>'DOS',
	'dot'=>'dot',
	'e'=>'E',
	'ecmascript'=>'ECMAScript',
	'eiffel'=>'Eiffel',
	'email'=>'eMail (mbox)',
	'epc'=>'EPC',
	'erlang'=>'Erlang',
	'euphoria'=>'Euphoria',
	'ezt'=>'EZT',
	'f1'=>'Formula One',
	'falcon'=>'Falcon',
	'fo'=>'FO (abas-ERP)',
	'fortran'=>'Fortran',
	'freebasic'=>'FreeBasic',
	'fsharp'=>'F#',
	'gambas'=>'GAMBAS',
	'gdb'=>'GDB',
	'genero'=>'Genero',
	'genie'=>'Genie',
	'gettext'=>'GNU Gettext',
	'glsl'=>'glSlang',
	'gml'=>'GML',
	'gnuplot'=>'GNUPlot',
	'go'=>'Go',
	'groovy'=>'Groovy',
	'gwbasic'=>'GwBasic',
	'haskell'=>'Haskell',
	'haxe'=>'Haxe',
	'hicest'=>'HicEst',
	'hq9plus'=>'HQ9+',
	'html4strict'=>'HTML 4.01',
	'html5'=>'HTML 5',
	'icon'=>'Icon',
	'idl'=>'Uno Idl',
	'ini'=>'INI',
	'inno'=>'Inno Script',
	'intercal'=>'INTERCAL',
	'io'=>'IO',
	'ispfpanel'=>'ISPF Panel',
	'j'=>'J',
	'java'=>'Java',
	'java5'=>'Java 5',
	'javascript'=>'JavaScript',
	'jcl'=>'JCL',
	'jquery'=>'jQuery',
	'kixtart'=>'KiXtart',
	'klonec'=>'KLone C',
	'klonecpp'=>'KLone C++',
	'latex'=>'LaTeX',
	'lb'=>'Liberty BASIC',
	'ldif'=>'LDIF',
	'lisp'=>'Lisp',
	'llvm'=>'LLVM',
	'locobasic'=>'Locomotive Basic',
	'logtalk'=>'Logtalk',
	'lolcode'=>'LOLcode',
	'lotusformulas'=>'Lotus Notes @Formulas',
	'lotusscript'=>'LotusScript',
	'lscript'=>'Lightwave Script',
	'lsl2'=>'Linden Script',
	'lua'=>'LUA',
	'm68k'=>'Motorola 68000 Assembler',
	'magiksf'=>'MagikSF',
	'make'=>'GNU make',
	'mapbasic'=>'MapBasic',
	'matlab'=>'Matlab M',
	'mirc'=>'mIRC Scripting',
	'mmix'=>'MMIX',
	'modula2'=>'Modula-2',
	'modula3'=>'Modula-3',
	'mpasm'=>'Microchip Assembler',
	'mxml'=>'MXML',
	'mysql'=>'MySQL',
	'nagios'=>'Nagios',
	'netrexx'=>'NetRexx',
	'newlisp'=>'NewLisp',
	'nginx'=>'Nginx',
	'nsis'=>'NSIS',
	'oberon2'=>'Oberon-2',
	'objc'=>'Objective-C',
	'objeck'=>'Objeck',
	'ocaml'=>'Ocaml',
	'ocaml-brief'=>'OCaml (Brief)',
	'octave'=>'GNU/Octave',
	'oobas'=>'OpenOffice.org Basic',
	'oorexx'=>'ooRexx',
	'oracle11'=>'Oracle 11 SQL',
	'oracle8'=>'Oracle 8 SQL',
	'oxygene'=>'Oxygene (Delphi Prism)',
	'oz'=>'OZ',
	'parasail'=>'ParaSail',
	'parigp'=>'PARI/GP',
	'pascal'=>'Pascal',
	'pcre'=>'PCRE',
	'per'=>'Per (forms)',
	'perl'=>'Perl',
	'perl6'=>'Perl 6',
	'pf'=>'OpenBSD Packet Filter',
	'php'=>'PHP',
	'php-brief'=>'PHP (Brief)',
	'pic16'=>'PIC16 Assembler',
	'pike'=>'Pike',
	'pixelbender'=>'Pixel Bender',
	'pli'=>'PL/I',
	'plsql'=>'PL/SQL',
	'postgresql'=>'PostgreSQL',
	'povray'=>'POVRAY',
	'powerbuilder'=>'PowerBuilder',
	'powershell'=>'PowerShell',
	'proftpd'=>'ProFTPd config',
	'progress'=>'Progress',
	'prolog'=>'Prolog',
	'properties'=>'Properties',
	'providex'=>'ProvideX',
	'purebasic'=>'PureBasic',
	'pycon'=>'Python (console mode)',
	'pys60'=>'Python for S60',
	'python'=>'Python',
	'qbasic'=>'QuickBASIC',
	'racket'=>'Racket',
	'rails'=>'Ruby on Rails',
	'rbs'=>'RBScript',
	'rebol'=>'REBOL',
	'reg'=>'Microsoft REGEDIT',
	'rexx'=>'Rexx',
	'robots'=>'robots.txt',
	'rpmspec'=>'RPM Specification File',
	'rsplus'=>'R / S+',
	'ruby'=>'Ruby',
	'sas'=>'SAS',
	'scala'=>'Scala',
	'scheme'=>'Scheme',
	'scilab'=>'SciLab',
	'scl'=>'SCL',
	'sdlbasic'=>'sdlBasic',
	'smalltalk'=>'Smalltalk',
	'smarty'=>'Smarty',
	'spark'=>'SPARK',
	'sparql'=>'SPARQL',
	'sql'=>'SQL',
	'stonescript'=>'StoneScript',
	'systemverilog'=>'SystemVerilog',
	'tcl'=>'TCL',
	'teraterm'=>'Tera Term Macro',
	'text'=>'Plain Text',
	'thinbasic'=>'thinBasic',
	'tsql'=>'T-SQL',
	'typoscript'=>'TypoScript',
	'unicon'=>'Unicon',
	'upc'=>'UPC',
	'urbi'=>'Urbi',
	'unrealscript'=>'Unreal Script',
	'vala'=>'Vala',
	'vb'=>'Visual Basic',
	'vbnet'=>'VB.NET',
	'vbscript'=>'VB Script',
	'vedit'=>'Vedit Macro',
	'verilog'=>'Verilog',
	'vhdl'=>'VHDL',
	'vim'=>'Vim',
	'visualfoxpro'=>'Visual FoxPro',
	'visualprolog'=>'Visual Prolog',
	'whitespace'=>'Whitespace',
	'whois'=>'WHOIS (RPSL format)',
	'winbatch'=>'WinBatch',
	'xbasic'=>'XBasic',
	'xml'=>'XML',
	'xorg_conf'=>'Xorg Config',
	'xpp'=>'X++',
	'yaml'=>'YAML',
	'z80'=>'ZiLOG Z80 Assembler',
	'zxbasic'=>'ZXBasic',
);

// Popular formats that are listed first.".'
$popular_formats=array('."
	'text','html4strict','html5','css','javascript','php',
	'perl','python','postgresql','sql','xml',
	'java','c','csharp','cpp',
);
?>";

file_put_contents('config.php',$data);

echo "1";

fx:
?>