
/**
* select option responsive jumpmenu
*/
function res_jumpmenu(targ,selObj,restore){ //v3.0
    eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
    //if (restore) selObj.selectedIndex= 0;
}

function iFrameHeight() {
    if(document.getElementById && !(document.all)) {
        h = document.getElementById('iframename').contentDocument.body.scrollHeight;
        document.getElementById('iframename').style.height = h;
        w = document.getElementById('iframename').contentDocument.body.scrollHeight;
        document.getElementById('iframename').style.height = w;
    } else if (document.all) {
        h = document.frames('iframename').document.body.scrollHeight;
        document.all.iframename.style.height = h;
        w = document.getElementById('iframename').contentDocument.body.scrollHeight;
        document.getElementById('iframename').style.height = w;
    }
}
/********************************
* obj : - string:md5
*  	    - obj:{"autoopen":true} (case:wysi)
* url : - string:"www.kapook.com"
		- obj:this (case:wysi)
*********************************/
function openDialogOption(obj,url) {
if (typeof obj == 'string') {
    eval("var obj=opt_"+obj);
    var sideUrl = url;
} else {
//=== case wysi
    if (typeof url == 'string') {
        var sideUrl = url;
    } else {
		if (url.getAttribute('goUrl')){ 
            var sideUrl = url.getAttribute('goUrl');
        } else {
            var sideUrl=url.href;
            url.setAttribute('goUrl',sideUrl);
        }
        url.href="javascript::void(0)";
        url.target="";
	}
	//case fullscreen
	if (obj.height == undefined && obj.width == undefined) {
    	SiteWindow = window.open(sideUrl,"_blank", "fullscreen=yes,toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, directories=no, status=no");
    	return true;
    }
}

    obj.autoOpen = true;   
    obj.height = (obj.height == undefined || obj.height == "auto") ? window.innerHeight-100 : parseInt(obj.height); 
    obj.width = (obj.width == undefined || obj.width == "auto") ? window.innerWidth-100 : parseInt(obj.width);
    if(obj.zIndex) obj.zIndex = parseInt(obj.zIndex);
    var divDialog = jQuery("<div/>").attr("style","width:"+obj.width+";height:"+obj.height+";");
    
    jQuery("<iframe/>").attr({
        "id":"iframename",
        "overflow":"scroll",
        "style":"width:100%;height:100%;border:none;",
        "src": sideUrl,
        "onload":"iFrameHeight();"
    }).appendTo(divDialog);
    divDialog.dialog(obj);
}
                
function openCustomSize(PageURL, Width, Height, ToolBar, Location, StatusBar, MenuBar, Resizeable, ScrollBars) {
    if (Width > 0 && Height > 0) {
        var setTop = (screen.height - Height) / 2;
        var setLeft = (screen.width - Width) / 2;
        var siteOpen = 'width='+Width+', height='+Height+', left='+setLeft+', top='+setTop+', ';
    } else {
        //var siteOpen = 'fullscreen=yes, ';
        var siteOpen = 'width='+window.screen.availWidth+', height='+window.screen.availHeight+', left=0, top=0, ';
    }
    var siteOption = siteOpen+'toolbar='+ToolBar+', location='+Location+', status='+StatusBar+', menubar='+MenuBar+', resizable='+Resizeable+', scrollbars='+ScrollBars;
    SiteWindow = window.open(PageURL , "_blank", ""+siteOption+"");
}
		
	jQuery(document).ready(function() {
        page =  document.location.href ? document.location.href : document.location;
        var poiont = jQuery('.rvnavigator a[href="' + page + '"]').parents("li").length;
        if (poiont > 0) {
            for (i=0;i<=poiont;i++) { 
               jQuery('.rvnavigator a[href="' + page + '"]').parents("li").eq(i).find('a:first').attr('class', 'current');
            }
        }
        
    });