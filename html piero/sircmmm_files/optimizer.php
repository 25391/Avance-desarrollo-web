
/**
 * Tools:
 *   - easy clearing method
 *   - replace (useful for screen readers)
 *   - accessibility (useful for screen readers)
 *
 * @package    themes
 * @subpackage default2
 */

/* clearing */
.stretch,
.clear {
    clear: both;
    height: 1px;
    margin: 0;
    padding: 0;
    font-size: 15px;
    line-height: 1px;
}
.clearfix:after {
    content: ".";
    display: block;
    height: 0;
    clear: both;
    visibility: hidden;
}
.clearfix { /* make method ie7 compatible */
    #display: inline-block;
}
* html .clearfix {
    /* Hides from IE-mac \*/
    height: 1%;
    display: block; /* restore block display for ie6 */
    /* End hide from IE-mac */
}
/* end clearing */


/* replace */
.replace {
    display: block;

    background-repeat: no-repeat;
    background-position: left top;
    background-color: transparent;
}
/* tidy these up */
.replace * {
    text-indent: -10000px;
    display: block;

    background-repeat: no-repeat;
    background-position: left top;
    background-color: transparent;
}
    .replace a {
        text-indent: 0;
    }
        .replace a span {
            text-indent: -10000px;
        }
/* end replace */


/* accessibility */
span.accesskey {
    text-decoration: none;
}
.accessibility {
    position: absolute;
    top: -9999em;
    left: -9999em;
}
/* end accessibility */


/* hide */
.hide {
    display: none;
}fieldset.form {
	border:1px #4682b4 solid;
	margin-bottom:1em;
	background:#f3f9ff;
}
.form fieldset{
	margin-bottom: 1.2em;
}
/*----------------- Form no tab ---------------------*/

div #frame {
	background:#f3f9ff;
	border:1px #4682b4 solid;
	margin-bottom:1em;
	margin-top:-5px;
	color:#0f4775;
	width:80%;
	text-align:center;
}	

fieldset.singleBlock {
    padding:10px 0 0 0;
}
fieldset.noLegend {
    padding-top: 0;
}
fieldset.lastChild {
    margin-top: 0;
	margin-bottom: 0;
    padding-bottom: 0;
}
fieldset.lastChild p {
    margin-top: 0;
    padding-top: 0; 
	color:#000000; 
}
    fieldset legend {
		color:#FFFFFF;
		margin-bottom:0.8em;
		#margin-left: -8px;
		padding:0.3em;
		width:710px;
    }
/*fieldset*/ 
div.title {
		color:#3874a7;
		background:#dcebf8;
		padding:7px;
		border-bottom:1px #ffffff solid;
		font-weight: bold;
    }

/* Form elements */
input.text, select, textarea {
    border-width: 1px;
    border-style: solid;
    border-color: #7c7c7c #c3c3c3 #ddd #c3c3c3;
    width: 170px;
    /* padding: 2px;*/
    background: #fff url(/themes/rvtheme/images/bg/form_input_m.gif) repeat-x left top;
    font-size: 0.9em;
    color: #666;
}
textarea {
    height: 6em;
}
label {
    color: #0f4775;
}
/* Ordered list for displaying form elements */
form fieldset ol {
    margin: 0;
    list-style: none;
    line-height: 1em;
	padding-left: 10px;
}
    form fieldset ol li {
        clear: left;
        margin: 0;
        padding-bottom: 0.6em;
        padding-left: 160px;
            }
        form fieldset ol li div {
                        #display: inline; /* fix MSIE */
            margin-bottom: 0;
        }
        form fieldset ol li label {
            float: left;
            margin-left: -160px;
            width: 140px;
            text-align: right;
        }
        form fieldset ol li p { /* field comments */
            margin-top: 0.2em;
            margin-bottom: 0;
            font-size: 0.9em;
        }
        form fieldset ol li p.error { /* field error */
            margin-top: 0;
            margin-bottom: 0.3em;
            color: #c20000;
        }


/* Fields on top */
form fieldset ol.onTop {
}
    form fieldset ol.onTop li {
        clear: none;
        padding-left: 0;
            }
        
        form fieldset ol.onTop li label {
            float: none;
            display: block;
            margin-left: 0;
            margin-bottom: 0.2em;
            width: auto;
            text-align: left;
        }


/* Additional */
form em {
    font-style: normal;
    color: #c20000;
}
form div,
form p {
   /*  margin-bottom: 1em; */  /* compo  */
	color:#0f4775;
}
form .fieldIndent {
    margin-left: 160px;
}
	form .fieldIndent a {
			color:#3874a7;
			text-decoration: underline;
		}		

	form .fieldIndent a:hover {
		color: #64a1d3;
		text-decoration: underline;
	}
		

/* No forms layout */
div.fieldsetlike {
	margin-bottom:1em;
	background:#f3f9ff;
}
    div.fieldsetlike h3 {
        margin-bottom: 0.6em;
        font-weight: bold;
        font-size: 1.1em;
        line-height: 1.1em;
        color: #f9fbfc;
    }
    div.fieldsetlike dl {
		padding-top:5px;
        margin-left: 380px;
        margin-bottom: 0;
        line-height: 1em;
    }
        div.fieldsetlike dl dt {
            float: left;
            display: inline;

            overflow: hidden; /* one row label only */
            height: 1.2em;

            margin-left: -160px;
            width: 140px;
            text-align: right;
            font-weight: normal;
            color: #0f4775;
        }
        div.fieldsetlike dl dd {
            margin-left: 0;
            margin-bottom: 0.4em;

            min-height: 1.2em;
            _height: 1.2em; /* min height for ie6 */

            padding-bottom: 0.2em; /* fix MSIE bug */
            color: #0f4775;
        }
		div.fieldsetlike a {
			color:#3874a7;
			text-decoration: underline;
		}		

		div.fieldsetlike a:hover {
			color: #64a1d3;
			text-decoration: underline;
		}
		
p#require {
	background:#4682b4;
	color:#ffffff;
	text-align:left;
	padding:1.5em 1em 1.5em 1em;
	margin:0em;
	font-size:0.9em;
	border-top:1px solid #4682b4;
	vertical-align:middle;
}			
p#require em {
	color:#ff2929;
}
p.bottomForm {
	padding:1em 0 0 0;
	text-align:center;
}	
		 
a.button, a.button:hover {
  background-color:#D4D0C8;
  background-position:top;
  padding: 3px 10px 3px 10px;
  border-top: 2px solid #FFFFFF;
  border-left: 2px solid #FFFFFF;
  border-bottom: 2px solid #808080;
  border-right: 2px solid #808080;
  color:#000000;
  text-decoration: none; 
  font-size: 1em;   
}

a.button:active {
  background-color:#D4D0C8;
  background-position:bottom;
  padding: 3px 10px 3px 10px;
  border-top: 2px solid #808080;
  border-left: 2px solid #808080;
  border-bottom: 2px solid #FFFFFF;
  border-right: 2px solid #FFFFFF;
  color: #000000;
  text-decoration: none; 
  font-size: 1em;   
}	

div#bottomLine {
	background:#ffffff;
	color:#ffffff;
	text-align:left;
	padding:1.5em 1em 0.5em 1em;
	margin:0em;
	font-size:0.9em;
	border-top:1px solid #4682b4;
	vertical-align:middle;
}
/* END no forms layout */


/* START RVS Block */

#RVS_Block{
	font-weight: normal;
	color:#0f4775;
}
#RVS_Block .rvs_border {	
	border:1px solid #4682b4;
	background:#f3f9ff;
}
.rvs_h1 {	
	color:#f9fbfc;
	background:#4682b4;
	padding:1px;
	border-bottom:1px #4682b4 solid;
	font-weight: bold; 
	font-size:12px;
}
#RVS_Block .rvs_h1 div {	
	color:#f9fbfc;
	background:#4682b4;
	padding:7px 7px 0 7px;
	font-weight: bold;
}
#RVS_Block .rvs_Title {	
	color:#0f4775;
	font-weight: bold;
	text-align:right;
	padding:3px;
}
#RVS_Block .rvs_pad {	
	padding:3px 0;
}
#RVS_Block a:link, #RVS_Block a:visited, #RVS_Block a:active {	
	color:#3874a7;
	font-weight: normal;
	text-decoration: underline;
}
#RVS_Block a:hover {	
	color: #64a1d3;
	font-weight: normal;
	text-decoration: underline;
}
#RVS_Block em {
	color:#ff2929;
}
#RVS_Block .rvs_infoMessage {
	color:#00a009;
	margin:15px 5px;
}
#RVS_Block .rvs_errorMessage {
	color:#ff2929;
	padding:0;
	margin:0;
}
#RVS_Block .txtcolor {
	color: #000000;
}
#RVS_Block .error{
	color: #FF0000;
}
.Newspad{margin:15px;}
.Newscenter{ text-align:center;}
/* END RVS Block */
/******** Hidden block login **********/
#RVS_hideblock {
    display:none!important;
}html { /* inforces screen to show scrollbar */

}
body {
    margin:0;
	padding:0;
}

/* Header */
div#header {
}
    div#header h1 {
        position: absolute;
        top: 7px;
        padding-top: 20px;
        background: url(/themes/rvtheme/images/logo.gif) no-repeat left top;

        font-size: 30px;
        font-family: "Trebuchet MS";
    }
        div#header h1 a {
            background-color: transparent;
            text-decoration: none;
            color: #fff;

            display: block;
            width: 305px;
            height: 40px;
        }
            div#header h1 a span {
                display: block;
                text-indent: -9999px;
            }
/* END header */




/* Left/right blocks */
div.block {
	margin-left: 1em;
    margin-bottom: 1.5em;
	border: 1px solid #363636;
	background:#ECECEC;
	text-align:left;
	color:#000000;
}
    div.block h2 {
	padding: 0.3em;
    border-bottom: 1px solid #000000;
	background:#595959;
    color:#FFFFFF;
    font-weight: bold;
	font-size: 1.1em;
    }
    div.block div.content {
    padding: 0.4em 10px;
    font-size: 0.9em;
    }
	
	div.block div.content a {
	color:#C32321; 
	text-decoration:underline;
	font-size:1em;
	}

	div.block div.content a:hover {
	color:#920706; 
	text-decoration:underline;	
	font-size:1em;
	}			
	
/* END left/right blocks */

/******** Hidden block login **********/
#RVS_hideblock {
    display:none!important;
}
/**
 * Blocks.
 *
 * @package    themes
 * @subpackage default2
 * @author     Dmitri Lakachauskis <lakiboy83@gmail.com>
 */

/* Logout */
div#block-logout {
}
    div#block-logout strong {
        color: #666;
        color: #333;
    }
    div#block-logout em {
        font-style: normal;
    }


/* Lang switcher */
div#langSwitcher {
    float: right;
}
    div#langSwitcher a {
        float: left;
        margin-left: 15px;
    }
        div#langSwitcher a img {
            display: block;
        }


/* Breadcrumbs */
#breadcrumbs {
    margin: 0;
    float: left;
}
    #breadcrumbs a {
        font-weight: bold;
        color: #66A326;
    }
div.message {
    margin: 0 auto;
	color:#c20000;
	font-weight:bold;
	border:0;
}
    div.message p {
        margin-bottom: 1em;
        padding: 0.5em;
        text-align:left;	
    }
    
    div.message, p.message-error, div.message-error {
        color: #ff2929;
        padding:0px;   
		margin:0px;
    }
    div.message, p.message-info, div.message-info {
        color: #00a009;
		margin-bottom: 1em;   
    }
    div.message, p.message-warning, div.message-warning {
        border-color: #999;
        color: #999;
        padding: 10px;          
    }
/* Headings */
h1.title {
	color:#f9fbfc;
	background:#4682b4;
	font-size: 1.5em;
	font-weight: bold;
	padding:5px;
	margin:0 0 15px 0;
}


/******** Hidden block login **********/
#RVS_hideblock {
    display:none!important;
}
 /**********************  Start Blockloginform/style.css  *************************/

.RVS_leftside div.RVS_Blockloginform table.rvs_frame {
	text-align:left;
}
.RVS_leftside div.RVS_Blockloginform table tr td.rvs_h2 {
	font-size: 1.1em;
	padding:5px 4px; 
	font-weight:bold;
}	
.RVS_leftside div.RVS_Blockloginform a {	
	text-decoration: underline;
	}	
.RVS_leftside div.RVS_Blockloginform a:hover {	
	text-decoration: underline;
	}
#RVS_rightside div.RVS_Blockloginform table.rvs_frame {
	text-align:left;
}
#RVS_rightside div.RVS_Blockloginform table tr td.rvs_h2 {
	font-size: 1.1em;
	padding:5px 4px; 
	font-weight:bold;
}	
#RVS_rightside div.RVS_Blockloginform a {	
	text-decoration: underline;
	}	
#RVS_rightside div.RVS_Blockloginform a:hover {	 
	text-decoration: underline;
	}
.tryoutbgbanner{ 
    background-image: url(../images/buy_account.jpg); 
    background-position:top left; 
    background-repeat:no-repeat; 
    width:217px; 
    height:81px; 
	margin-top:7px;
}
.tryoutbgbanner div{ 
    padding:25px 5px 0 80px; 
}
 
.RVS_leftside div.RVS_Blockloginform .tryoutbgbanner a:link,
.RVS_leftside div.RVS_Blockloginform .tryoutbgbanner a:active,
.RVS_leftside div.RVS_Blockloginform .tryoutbgbanner a:visited
 { 
 color:#fff;
 font-weight:bold; 
 text-decoration: none;
 } 
.RVS_leftside div.RVS_Blockloginform .tryoutbgbanner a:hover { 
 color:#FFEFAD;
 font-weight:bold;
 text-decoration: none;
 }
 
 
 /**********************  Start Newsletter/style.css  *************************/

.RVS_leftside div.RVS_Newsletter table.rvs_frame {
    text-align:left;
}
.RVS_leftside div.RVS_Newsletter table tr td.rvs_h2 {
    font-size: 1.1em;
    padding:5px 4px; 
    font-weight:bold;
}   
.RVS_leftside div.RVS_Newsletter a {    
    text-decoration: underline;
    }   
.RVS_leftside div.RVS_Newsletter a:hover {  
    text-decoration: underline;
    }
#RVS_rightside div.RVS_Newsletter table.rvs_frame {
    text-align:left;
}
#RVS_rightside div.RVS_Newsletter table tr td.rvs_h2 {
    font-size: 1.1em;
    padding:5px 4px; 
    font-weight:bold;
}   
#RVS_rightside div.RVS_Newsletter a {   
    text-decoration: underline;
    }   
#RVS_rightside div.RVS_Newsletter a:hover { 
    text-decoration: underline;
    }
.tryoutbgbanner{ 
    background-image: url(../images/buy_account.jpg); 
    background-position:top left; 
    background-repeat:no-repeat; 
    width:217px; 
    height:81px; 
    margin-top:7px;
}
.tryoutbgbanner div{ 
    padding:25px 5px 0 80px; 
}
 
.RVS_leftside div.RVS_Newsletter .tryoutbgbanner a:link,
.RVS_leftside div.RVS_Newsletter .tryoutbgbanner a:active,
.RVS_leftside div.RVS_Newsletter .tryoutbgbanner a:visited
 { 
 color:#fff;
 font-weight:bold; 
 text-decoration: none;
 } 
.RVS_leftside div.RVS_Newsletter .tryoutbgbanner a:hover { 
 color:#FFEFAD;
 font-weight:bold;
 text-decoration: none;
 }
 
/*ใช้ซ่อนบล็อกล็อกอินโปรเจ็คที่เป็น blog*/	
#RVS_hideblock {display:none!important;}