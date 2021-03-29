
/**
 * Main Seagull JavaScript library.
 *
 * @package seagull
 * @subpackage SGL
 */
var SGL = {
    isReady: false,
    ready: function(f) {
        // If the DOM is already ready
        if (SGL.isReady) {
            // Execute the function immediately
            if (typeof f == 'string') {
                eval(f);
            } else if (typeof f == 'function') {
                f.apply(document);
            }
        // Otherwise add the function to the wait list
        } else {
            SGL.onReadyDomEvents.push(f);
        }
    },
    onReadyDomEvents: [],
    onReadyDom: function() {
        // make sure that the DOM is not already loaded
        if (!SGL.isReady) {
            // Flag the DOM as ready
            SGL.isReady = true;

            if (SGL.onReadyDomEvents) {
                for (var i = 0, j = SGL.onReadyDomEvents.length; i < j; i++) {
                    if (typeof SGL.onReadyDomEvents[i] == 'string') {
                        eval(SGL.onReadyDomEvents[i]);
                    } else if (typeof SGL.onReadyDomEvents[i] == 'function') {
                        SGL.onReadyDomEvents[i].apply(document);
                    }
                }
                // Reset the list of functions
				SGL.onReadyDomEvents = null;
            }
        }
    }
};

/**
 *  Cross-browser onDomReady solution
 *  Dean Edwards/Matthias Miller/John Resig
 */
new function() {
    /* for Mozilla/Opera9 */
    if (document.addEventListener) {
        document.addEventListener("DOMContentLoaded", SGL.onReadyDom, false);
    }

    /* for Internet Explorer */
    /*@cc_on @*/
    /*@if (@_win32)
        document.write("<script id=__ie_onload defer src=javascript:void(0)><\/script>");
        var script = document.getElementById("__ie_onload");
        script.onreadystatechange = function() {
            if (this.readyState == "complete") {
                SGL.onReadyDom(); // call the onload handler
            }
        };
    /*@end @*/

    /* for Safari */
    if (/WebKit/i.test(navigator.userAgent)) { // sniff
        SGL.webkitTimer = setInterval(function() {
            if (/loaded|complete/.test(document.readyState)) {
                // Remove the timer
                clearInterval(SGL.webkitTimer);
                SGL.webkitTimer = null;
                // call the onload handler
                SGL.onReadyDom();
            }
        }, 10);
    }

    /* for other browsers */
    oldWindowOnload = window.onload || null;
    window.onload = function() {
        if (oldWindowOnload) {
            oldWindowOnload();
        }
        SGL.onReadyDom();
    }
}

// ----------
// --- BC ---
// ----------

/**
 * Used for async load of sourcefourge bloody button,
 */
function async_load()
{
    var node;
    try {
        // variable _asyncDom is set from JavaScript in the iframe
        // node = top._asyncDom.cloneNode(true); // kills Safari 1.2.4
        node = top._asyncDom;
        // try to remove the first script element, the one that
        // executed all document.writes().
        node.removeChild(node.getElementsByTagName('script')[0]);
    } catch (e) {}
    try {
        // insert DOM fragment at a DIV with id "async_demo" on current page
        document.getElementById('async_demo').appendChild(node);
    } catch (e) {
        try {
            // fallback for some non DOM compliant browsers
            document.getElementById('async_demo').innerHTML = node.innerHTML;
        } catch (e2) {};
    }
}

/**
 * Make Seagull SEF URL.
 *
 * @param object params
 *
 * @return string
 */
function makeUrl(params)
{
    var ret = SGL_JS_FRONT_CONTROLLER != ''
        ? SGL_JS_WEBROOT + '/' + SGL_JS_FRONT_CONTROLLER
        : SGL_JS_WEBROOT;
    var moduleName = params.module ? params.module : '';
    var managerName = params.manager ? params.manager : moduleName;

    switch (SGL_JS_URL_STRATEGY) {

    // make classic URL
    case 'SGL_UrlParser_ClassicStrategy':
        if (ret.charAt(ret.length - 1) != '?') {
            ret = ret + '?';
        }
        ret = ret + 'moduleName=' + escape(moduleName) + '&managerName=' + escape(managerName);
        for (x in params) {
            if (x == 'module' || x == 'manager') {
                continue;
            }
            // add param
            ret = '&' + ret + escape(x) + '=' + escape(params[x]);
        }
        break;

    // make default Seagull SEF URL
    default:
        ret = ret + '/' + escape(moduleName) + '/' + escape(managerName) + '/';
        for (x in params) {
            if (x == 'module' || x == 'manager') {
                continue;
            }
            ret = ret + escape(x) + '/' + escape(params[x]) + '/';
        }
        break;
    }
    return ret;
}

SGL.ready(function() {
    var msg = document.getElementById('broadcastMessage');
    if (msg) {
        msg.getElementsByTagName('a')[0].onclick = function() {
            msg.style.display = 'none';
        }
    }
});function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

//v1.0
//Copyright 2006 Adobe Systems, Inc. All rights reserved.
function AC_AddExtension(src, ext)
{
  if (src.indexOf('?') != -1)
    return src.replace(/\?/, ext+'?'); 
  else
    return src + ext;
}

function AC_Generateobj(objAttrs, params, embedAttrs) 
{ 
  var str = '<object ';
  for (var i in objAttrs)
    str += i + '="' + objAttrs[i] + '" ';
  str += '>';
  for (var i in params)
    str += '<param name="' + i + '" value="' + params[i] + '" /> ';
  str += '<embed ';
  for (var i in embedAttrs)
    str += i + '="' + embedAttrs[i] + '" ';
  str += ' ></embed></object>';

  document.write(str);
}

function AC_FL_RunContent(){
  var ret = 
    AC_GetArgs
    (  arguments, ".swf", "movie", "clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
     , "application/x-shockwave-flash"
    );
  AC_Generateobj(ret.objAttrs, ret.params, ret.embedAttrs);
}

function AC_SW_RunContent(){
  var ret = 
    AC_GetArgs
    (  arguments, ".dcr", "src", "clsid:166B1BCA-3F9C-11CF-8075-444553540000"
     , null
    );
  AC_Generateobj(ret.objAttrs, ret.params, ret.embedAttrs);
}

function AC_GetArgs(args, ext, srcParamName, classid, mimeType){
  var ret = new Object();
  ret.embedAttrs = new Object();
  ret.params = new Object();
  ret.objAttrs = new Object();
  for (var i=0; i < args.length; i=i+2){
    var currArg = args[i].toLowerCase();    

    switch (currArg){	
      case "classid":
        break;
      case "pluginspage":
        ret.embedAttrs[args[i]] = args[i+1];
        break;
      case "src":
      case "movie":	
        args[i+1] = AC_AddExtension(args[i+1], ext);
        ret.embedAttrs["src"] = args[i+1];
        ret.params[srcParamName] = args[i+1];
        break;
      case "onafterupdate":
      case "onbeforeupdate":
      case "onblur":
      case "oncellchange":
      case "onclick":
      case "ondblClick":
      case "ondrag":
      case "ondragend":
      case "ondragenter":
      case "ondragleave":
      case "ondragover":
      case "ondrop":
      case "onfinish":
      case "onfocus":
      case "onhelp":
      case "onmousedown":
      case "onmouseup":
      case "onmouseover":
      case "onmousemove":
      case "onmouseout":
      case "onkeypress":
      case "onkeydown":
      case "onkeyup":
      case "onload":
      case "onlosecapture":
      case "onpropertychange":
      case "onreadystatechange":
      case "onrowsdelete":
      case "onrowenter":
      case "onrowexit":
      case "onrowsinserted":
      case "onstart":
      case "onscroll":
      case "onbeforeeditfocus":
      case "onactivate":
      case "onbeforedeactivate":
      case "ondeactivate":
      case "type":
      case "codebase":
        ret.objAttrs[args[i]] = args[i+1];
        break;
      case "width":
      case "height":
      case "align":
      case "vspace": 
      case "hspace":
      case "class":
      case "title":
      case "accesskey":
      case "name":
      case "id":
      case "tabindex":
        ret.embedAttrs[args[i]] = ret.objAttrs[args[i]] = args[i+1];
        break;
      default:
        ret.embedAttrs[args[i]] = ret.params[args[i]] = args[i+1];
    }
  }
  ret.objAttrs["classid"] = classid;
  if (mimeType) ret.embedAttrs["type"] = mimeType;
  return ret;
}



    // defalut script for use all project outsiteder
    // for confirm action onclick | delect | edit | change
    // -----------------------------------------------------------------
    // txt = text for display
    // -----------------------------------------------------------------
    // by siwakorn
    function rvsConfirmSubmit(txt) {
        if (typeof txt == 'undefined'){
            txt = 'Are you sure?';
        }
        
        if(confirm(txt)){
           return true;
        }else{
           return false; 
        }
    }

     // defalut script for use all project outsiteder
    // for change value input box on event | oncleck
    // input ----------------------------------------------------------
    // oInputID = <input id = "{oInputID}" name="" value="">
    // oData = data for input to value
    // ------------------------------------------------------------------
    // by siwakorn
    function controlInputValue(oInputID,oData) {
        document.getElementById(oID).value = oData;
    }
    
    // defalut script for use all project outsiteder
    // for display div | tag autor control by id
    // use onclink for disable or display
    // ------------------------------------------------------------------
    // divID = <div id="{divID}"></div>
    // ------------------------------------------------------------------
    // by siwakorn
    function disPlayDiv(divID) {
        var oDivID = document.getElementById(divID);
        oDivID.style.display = (oDivID.style.display == 'none') ? '' : 'none' ;
    }/*! Copyright (c) 2010 Brandon Aaron (http://brandonaaron.net)
 * Licensed under the MIT License (LICENSE.txt).
 *
 * Version 2.1.2
 */

(function($){

$.fn.bgiframe = ($.browser.msie && /msie 6\.0/i.test(navigator.userAgent) ? function(s) {
    s = $.extend({
        top     : 'auto', // auto == .currentStyle.borderTopWidth
        left    : 'auto', // auto == .currentStyle.borderLeftWidth
        width   : 'auto', // auto == offsetWidth
        height  : 'auto', // auto == offsetHeight
        opacity : true,
        src     : 'javascript:false;'
    }, s || {});
    var html = '<iframe class="bgiframe"frameborder="0"tabindex="-1"src="'+s.src+'"'+
                   'style="display:block;position:absolute;z-index:-1;'+
                       (s.opacity !== false?'filter:Alpha(Opacity=\'0\');':'')+
                       'top:'+(s.top=='auto'?'expression(((parseInt(this.parentNode.currentStyle.borderTopWidth)||0)*-1)+\'px\')':prop(s.top))+';'+
                       'left:'+(s.left=='auto'?'expression(((parseInt(this.parentNode.currentStyle.borderLeftWidth)||0)*-1)+\'px\')':prop(s.left))+';'+
                       'width:'+(s.width=='auto'?'expression(this.parentNode.offsetWidth+\'px\')':prop(s.width))+';'+
                       'height:'+(s.height=='auto'?'expression(this.parentNode.offsetHeight+\'px\')':prop(s.height))+';'+
                '"/>';
    return this.each(function() {
        if ( $(this).children('iframe.bgiframe').length === 0 )
            this.insertBefore( document.createElement(html), this.firstChild );
    });
} : function() { return this; });

// old alias
$.fn.bgIframe = $.fn.bgiframe;

function prop(n) {
    return n && n.constructor === Number ? n + 'px' : n;
}

})(jQuery);/**
 * labs_json Script by Giraldo Rosales.
 * Version 1.0
 * Visit www.liquidgear.net for documentation and updates.
 *
 *
 * Copyright (c) 2009 Nitrogen Design, Inc. All rights reserved.
 * 
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 * 
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 **/
 
/**
 * HOW TO USE
 * ==========
 * Encode:
 * var obj = {};
 * obj.name = "Test JSON";
 * obj.type = "test";
 * $.json.encode(obj); //output: {"name":"Test JSON", "type":"test"}
 * 
 * Decode:
 * $.json.decode({"name":"Test JSON", "type":"test"}); //output: object
 * 
 */

jQuery.json = {
    encode:function(value, replacer, space) {
        var i;
        gap = '';
        var indent = '';
        
        if (typeof space === 'number') {
            for (i = 0; i < space; i += 1) {
                indent += ' ';
            }
            
        } else if (typeof space === 'string') {
            indent = space;
        }
        
        rep = replacer;
        if (replacer && typeof replacer !== 'function' &&
                (typeof replacer !== 'object' ||
                 typeof replacer.length !== 'number')) {
            throw new Error('JSON.encode');
        }
        
        return this.str('', {'': value});
    },
    
    decode:function(text, reviver) {
        var j;
        var cx = /[\u0000\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g;
        
        function walk(holder, key) {
            var k, v, value = holder[key];
            
            if (value && typeof value === 'object') {
                for (k in value) {
                    if (Object.hasOwnProperty.call(value, k)) {
                        v = walk(value, k);
                        if (v !== undefined) {
                            value[k] = v;
                        } else {
                            delete value[k];
                        }
                    }
                }
            }
            return reviver.call(holder, key, value);
        }
        
        cx.lastIndex = 0;
        
        /* text is emptry return */
        if (typeof text != 'string' || text == "") {
        	return text;
        }
        
        if (typeof text == 'string' && cx.test(text)) {
            text = text.replace(cx, function (a) {
                return '\\u' + ('0000' + a.charCodeAt(0).toString(16)).slice(-4);
            });
        }
        
        if (typeof text == 'string' && /^[\],:{}\s]*$/.test(text.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g, '@').replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {
            j = eval('(' + text + ')');
            return typeof reviver === 'function' ? walk({'': j}, '') : j;
        }
        
        throw new SyntaxError('JSON.parse');
    },
    
    f:function(n) {
        return n < 10 ? '0' + n : n;
    },
    
    DateToJSON:function(key) {
        return this.getUTCFullYear() + '-' + this.f(this.getUTCMonth() + 1) + '-' + this.f(this.getUTCDate())      + 'T' + this.f(this.getUTCHours())     + ':' + this.f(this.getUTCMinutes())   + ':' + this.f(this.getUTCSeconds())   + 'Z';
    },
    
    StringToJSON:function(key) {
        return this.valueOf();
    },
    
    quote:function(string) {
        var meta = {'\b': '\\b','\t': '\\t','\n': '\\n','\f': '\\f','\r': '\\r','"' : '\\"','\\': '\\\\'};
        var escapable = /[\\\"\x00-\x1f\x7f-\x9f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g;
        
        escapable.lastIndex = 0;
        return escapable.test(string) ?
            '"' + string.replace(escapable, function (a) {
                var c = meta[a];
                return typeof c === 'string' ? c :
                    '\\u' + ('0000' + a.charCodeAt(0).toString(16)).slice(-4);
            }) + '"' :
            '"' + string + '"';
    },
    
    str:function(key, holder) {
        var indent='', gap = '', i, k, v, length, mind = gap, partial, value = holder[key];
        
        if (value && typeof value === 'object') {
            switch((typeof value)) {
                case 'date':
                    this.DateToJSON(key);
                    break;
                default:
                    this.StringToJSON(key);
                    break;
            }
        }
        
        if (typeof rep === 'function') {
            value = rep.call(holder, key, value);
        }
        switch (typeof value) {
            case 'string':
                return this.quote(value);
            case 'number':
                return isFinite(value) ? String(value) : 'null';
            case 'boolean':
            case 'null':
                return String(value);
            case 'object':
                if (!value) {
                    return 'null';
                }
                gap += indent;
                partial = [];
                
                if (Object.prototype.toString.apply(value) === '[object Array]') {
                    length = value.length;
                    
                    for (i = 0; i < length; i += 1) {
                        partial[i] = this.str(i, value) || 'null';
                    }
    
                    v = partial.length === 0 ? '[]' : gap ? '[\n' + gap + partial.join(',\n' + gap) + '\n' + mind + ']' : '[' + partial.join(',') + ']';
                    gap = mind;
                    return v;
                }
                    
                if (rep && typeof rep === 'object') {
                    length = rep.length;
                    for (i = 0; i < length; i += 1) {
                        k = rep[i];
                        if (typeof k === 'string') {
                            v = this.str(k, value);
                            if (v) {
                                partial.push(this.quote(k) + (gap ? ': ' : ':') + v);
                            }
                        }
                    }
                } else {
                    for (k in value) {
                        if (Object.hasOwnProperty.call(value, k)) {
                            v = this.str(k, value);
                            if (v) {
                                partial.push(this.quote(k) + (gap ? ': ' : ':') + v);
                            }
                        }
                    }
                }

                v = partial.length === 0 ? '{}' :
                    gap ? '{\n' + gap + partial.join(',\n' + gap) + '\n' +
                            mind + '}' : '{' + partial.join(',') + '}';
                gap = mind;
                return v;
        }
    }
};
/*!
 * jQuery Form Plugin
 * version: 3.09 (16-APR-2012)
 * @requires jQuery v1.3.2 or later
 *
 * Examples and documentation at: http://malsup.com/jquery/form/
 * Project repository: https://github.com/malsup/form
 * Dual licensed under the MIT and GPL licenses:
 *    http://malsup.github.com/mit-license.txt
 *    http://malsup.github.com/gpl-license-v2.txt
 */
/*global ActiveXObject alert */
;(function($) {
"use strict";

/*
    Usage Note:
    -----------
    Do not use both ajaxSubmit and ajaxForm on the same form.  These
    functions are mutually exclusive.  Use ajaxSubmit if you want
    to bind your own submit handler to the form.  For example,

    $(document).ready(function() {
        $('#myForm').on('submit', function(e) {
            e.preventDefault(); // <-- important
            $(this).ajaxSubmit({
                target: '#output'
            });
        });
    });

    Use ajaxForm when you want the plugin to manage all the event binding
    for you.  For example,

    $(document).ready(function() {
        $('#myForm').ajaxForm({
            target: '#output'
        });
    });
    
    You can also use ajaxForm with delegation (requires jQuery v1.7+), so the
    form does not have to exist when you invoke ajaxForm:

    $('#myForm').ajaxForm({
        delegation: true,
        target: '#output'
    });
    
    When using ajaxForm, the ajaxSubmit function will be invoked for you
    at the appropriate time.
*/

/**
 * Feature detection
 */
var feature = {};
feature.fileapi = $("<input type='file'/>").get(0).files !== undefined;
feature.formdata = window.FormData !== undefined;

/**
 * ajaxSubmit() provides a mechanism for immediately submitting
 * an HTML form using AJAX.
 */
$.fn.ajaxSubmit = function(options) {
    /*jshint scripturl:true */

    // fast fail if nothing selected (http://dev.jquery.com/ticket/2752)
    if (!this.length) {
        log('ajaxSubmit: skipping submit process - no element selected');
        return this;
    }
    
    var method, action, url, $form = this;

    if (typeof options == 'function') {
        options = { success: options };
    }

    method = this.attr('method');
    action = this.attr('action');
    url = (typeof action === 'string') ? $.trim(action) : '';
    url = url || window.location.href || '';
    if (url) {
        // clean url (don't include hash vaue)
        url = (url.match(/^([^#]+)/)||[])[1];
    }
   	/*RVSITEBUILDER MOD*/
   	if (RVS_AJAX_INDEX != undefined) url = RVS_AJAX_INDEX; else 
   	/*RVSITEBUILDER MOD*/
   	url = url || window.location.href || ''
   	/*RVSITEBUILDER MOD*/
    if (options.excUrlExternal) url = options.excUrlExternal;
    /*RVSITEBUILDER MOD*/
    options = $.extend(true, {
        url:  url,
        success: $.ajaxSettings.success,
        type: method || 'GET',
        iframeSrc: /^https/i.test(window.location.href || '') ? 'javascript:false' : 'about:blank'
    }, options || {});

    // hook for manipulating the form data before it is extracted;
    // convenient for use with rich editors like tinyMCE or FCKEditor
    var veto = {};
    this.trigger('form-pre-serialize', [this, options, veto]);
    if (veto.veto) {
        log('ajaxSubmit: submit vetoed via form-pre-serialize trigger');
        return this;
    }

    // provide opportunity to alter form data before it is serialized
    if (options.beforeSerialize && options.beforeSerialize(this, options) === false) {
        log('ajaxSubmit: submit aborted via beforeSerialize callback');
        return this;
    }

    var traditional = options.traditional;
    if ( traditional === undefined ) {
        traditional = $.ajaxSettings.traditional;
    }
    
    var elements = [];
    var qx, a = this.formToArray(options.semantic, elements);
    if (options.data) {
        options.extraData = options.data;
        qx = $.param(options.data, traditional);
    }

    // give pre-submit callback an opportunity to abort the submit
    if (options.beforeSubmit && options.beforeSubmit(a, this, options) === false) {
        log('ajaxSubmit: submit aborted via beforeSubmit callback');
        return this;
    }

    // fire vetoable 'validate' event
    this.trigger('form-submit-validate', [a, this, options, veto]);
    if (veto.veto) {
        log('ajaxSubmit: submit vetoed via form-submit-validate trigger');
        return this;
    }

    var q = $.param(a, traditional);
    if (qx) {
        q = ( q ? (q + '&' + qx) : qx );
    }    
    if (options.type.toUpperCase() == 'GET') {
        options.url += (options.url.indexOf('?') >= 0 ? '&' : '?') + q;
        options.data = null;  // data is null for 'get'
    }
    else {
        options.data = q; // data is the query string for 'post'
    }

    var callbacks = [];
    if (options.resetForm) {
        callbacks.push(function() { $form.resetForm(); });
    }
    if (options.clearForm) {
        callbacks.push(function() { $form.clearForm(options.includeHidden); });
    }

    // perform a load on the target only if dataType is not provided
    if (!options.dataType && options.target) {
        var oldSuccess = options.success || function(){};
        callbacks.push(function(data) {
            var fn = options.replaceTarget ? 'replaceWith' : 'html';
            $(options.target)[fn](data).each(oldSuccess, arguments);
        });
    }
    else if (options.success) {
        callbacks.push(options.success);
    }

    options.success = function(data, status, xhr) { // jQuery 1.4+ passes xhr as 3rd arg
        var context = options.context || options;    // jQuery 1.4+ supports scope context 
        for (var i=0, max=callbacks.length; i < max; i++) {
            callbacks[i].apply(context, [data, status, xhr || $form, $form]);
        }
    };

    // are there files to upload?
    var fileInputs = $('input:file:enabled[value]', this); // [value] (issue #113)
    var hasFileInputs = fileInputs.length > 0;
    var mp = 'multipart/form-data';
    var multipart = ($form.attr('enctype') == mp || $form.attr('encoding') == mp);

    var fileAPI = feature.fileapi && feature.formdata;
    log("fileAPI :" + fileAPI);
    var shouldUseFrame = (hasFileInputs || multipart) && !fileAPI;

    // options.iframe allows user to force iframe mode
    // 06-NOV-09: now defaulting to iframe mode if file input is detected
    if (options.iframe !== false && (options.iframe || shouldUseFrame)) {
        // hack to fix Safari hang (thanks to Tim Molendijk for this)
        // see:  http://groups.google.com/group/jquery-dev/browse_thread/thread/36395b7ab510dd5d
        if (options.closeKeepAlive) {
            $.get(options.closeKeepAlive, function() {
                fileUploadIframe(a);
            });
        }
          else {
            fileUploadIframe(a);
          }
    }
    else if ((hasFileInputs || multipart) && fileAPI) {
        fileUploadXhr(a);
    }
    else {
        $.ajax(options);
    }

    // clear element array
    for (var k=0; k < elements.length; k++)
        elements[k] = null;

    // fire 'notify' event
    this.trigger('form-submit-notify', [this, options]);
    return this;

     // XMLHttpRequest Level 2 file uploads (big hat tip to francois2metz)
    function fileUploadXhr(a) {
        var formdata = new FormData();

        for (var i=0; i < a.length; i++) {
            formdata.append(a[i].name, a[i].value);
        }

        if (options.extraData) {
            for (var p in options.extraData)
                if (options.extraData.hasOwnProperty(p))
                    formdata.append(p, options.extraData[p]);
        }

        options.data = null;

        var s = $.extend(true, {}, $.ajaxSettings, options, {
            contentType: false,
            processData: false,
            cache: false,
            type: 'POST'
        });
        
        if (options.uploadProgress) {
            // workaround because jqXHR does not expose upload property
            s.xhr = function() {
                var xhr = jQuery.ajaxSettings.xhr();
                if (xhr.upload) {
                    xhr.upload.onprogress = function(event) {
                        var percent = 0;
                        var position = event.loaded || event.position; /*event.position is deprecated*/
                        var total = event.total;
                        if (event.lengthComputable) {
                            percent = Math.ceil(position / total * 100);
                        }
                        options.uploadProgress(event, position, total, percent);
                    };
                }
                return xhr;
            };
        }

        s.data = null;
          var beforeSend = s.beforeSend;
          s.beforeSend = function(xhr, o) {
              o.data = formdata;
            if(beforeSend)
                beforeSend.call(o, xhr, options);
        };
        $.ajax(s);
    }

    // private function for handling file uploads (hat tip to YAHOO!)
    function fileUploadIframe(a) {
        var form = $form[0], el, i, s, g, id, $io, io, xhr, sub, n, timedOut, timeoutHandle;
        var useProp = !!$.fn.prop;

        if ($(':input[name=submit],:input[id=submit]', form).length) {
            // if there is an input with a name or id of 'submit' then we won't be
            // able to invoke the submit fn on the form (at least not x-browser)
            alert('Error: Form elements must not have name or id of "submit".');
            return;
        }
        
        if (a) {
            // ensure that every serialized input is still enabled
            for (i=0; i < elements.length; i++) {
                el = $(elements[i]);
                if ( useProp )
                    el.prop('disabled', false);
                else
                    el.removeAttr('disabled');
            }
        }

        s = $.extend(true, {}, $.ajaxSettings, options);
        s.context = s.context || s;
        id = 'jqFormIO' + (new Date().getTime());
        if (s.iframeTarget) {
            $io = $(s.iframeTarget);
            n = $io.attr('name');
            if (!n)
                 $io.attr('name', id);
            else
                id = n;
        }
        else {
            $io = $('<iframe name="' + id + '" src="'+ s.iframeSrc +'" />');
            $io.css({ position: 'absolute', top: '-1000px', left: '-1000px' });
        }
        io = $io[0];


        xhr = { // mock object
            aborted: 0,
            responseText: null,
            responseXML: null,
            status: 0,
            statusText: 'n/a',
            getAllResponseHeaders: function() {},
            getResponseHeader: function() {},
            setRequestHeader: function() {},
            abort: function(status) {
                var e = (status === 'timeout' ? 'timeout' : 'aborted');
                log('aborting upload... ' + e);
                this.aborted = 1;
                $io.attr('src', s.iframeSrc); // abort op in progress
                xhr.error = e;
                if (s.error)
                    s.error.call(s.context, xhr, e, status);
                if (g)
                    $.event.trigger("ajaxError", [xhr, s, e]);
                if (s.complete)
                    s.complete.call(s.context, xhr, e);
            }
        };

        g = s.global;
        // trigger ajax global events so that activity/block indicators work like normal
        if (g && 0 === $.active++) {
            $.event.trigger("ajaxStart");
        }
        if (g) {
            $.event.trigger("ajaxSend", [xhr, s]);
        }

        if (s.beforeSend && s.beforeSend.call(s.context, xhr, s) === false) {
            if (s.global) {
                $.active--;
            }
            return;
        }
        if (xhr.aborted) {
            return;
        }

        // add submitting element to data if we know it
        sub = form.clk;
        if (sub) {
            n = sub.name;
            if (n && !sub.disabled) {
                s.extraData = s.extraData || {};
                s.extraData[n] = sub.value;
                if (sub.type == "image") {
                    s.extraData[n+'.x'] = form.clk_x;
                    s.extraData[n+'.y'] = form.clk_y;
                }
            }
        }
        
        var CLIENT_TIMEOUT_ABORT = 1;
        var SERVER_ABORT = 2;

        function getDoc(frame) {
            var doc = frame.contentWindow ? frame.contentWindow.document : frame.contentDocument ? frame.contentDocument : frame.document;
            return doc;
        }
        
        // Rails CSRF hack (thanks to Yvan Barthelemy)
        var csrf_token = $('meta[name=csrf-token]').attr('content');
        var csrf_param = $('meta[name=csrf-param]').attr('content');
        if (csrf_param && csrf_token) {
            s.extraData = s.extraData || {};
            s.extraData[csrf_param] = csrf_token;
        }

        // take a breath so that pending repaints get some cpu time before the upload starts
        function doSubmit() {
            // make sure form attrs are set
            var t = $form.attr('target'), a = $form.attr('action');

            // update form attrs in IE friendly way
            form.setAttribute('target',id);
            if (!method) {
                form.setAttribute('method', 'POST');
            }
            if (a != s.url) {
                form.setAttribute('action', s.url);
            }

            // ie borks in some cases when setting encoding
            if (! s.skipEncodingOverride && (!method || /post/i.test(method))) {
                $form.attr({
                    encoding: 'multipart/form-data',
                    enctype:  'multipart/form-data'
                });
            }

            // support timout
            if (s.timeout) {
                timeoutHandle = setTimeout(function() { timedOut = true; cb(CLIENT_TIMEOUT_ABORT); }, s.timeout);
            }
            
            // look for server aborts
            function checkState() {
                try {
                    var state = getDoc(io).readyState;
                    log('state = ' + state);
                    if (state && state.toLowerCase() == 'uninitialized')
                        setTimeout(checkState,50);
                }
                catch(e) {
                    log('Server abort: ' , e, ' (', e.name, ')');
                    cb(SERVER_ABORT);
                    if (timeoutHandle)
                        clearTimeout(timeoutHandle);
                    timeoutHandle = undefined;
                }
            }

            // add "extra" data to form if provided in options
            var extraInputs = [];
            try {
                if (s.extraData) {
                    for (var n in s.extraData) {
                        if (s.extraData.hasOwnProperty(n)) {
                            extraInputs.push(
                                $('<input type="hidden" name="'+n+'">').attr('value',s.extraData[n])
                                    .appendTo(form)[0]);
                        }
                    }
                }

                if (!s.iframeTarget) {
                    // add iframe to doc and submit the form
                    $io.appendTo('body');
                	/*RVSITEBUILDER MOD*/
                	isErrorIFrame($io)
                	/*RVSITEBUILDER MOD*/
                    if (io.attachEvent)
                        io.attachEvent('onload', cb);
                    else
                        io.addEventListener('load', cb, false);
                }
                setTimeout(checkState,15);
                form.submit();
            }
            finally {
                // reset attrs and remove "extra" input elements
                form.setAttribute('action',a);
                if(t) {
                    form.setAttribute('target', t);
                } else {
                    $form.removeAttr('target');
                }
                $(extraInputs).remove();
            }
        }

        if (s.forceSync) {
            doSubmit();
        }
        else {
            setTimeout(doSubmit, 10); // this lets dom updates render
        }

        var data, doc, domCheckCount = 50, callbackProcessed;
		function isErrorIFrame(obj) {

        		iframeError =  obj.get(0);
        		if(iframeError.contentDocument) {
        			iframeErrors = iframeError.contentDocument;
        		} else {
        			if (iframeError.contentWindow) {
        			    iframeErrors = iframeError.contentWindow.document     				
        			} else {
        			    return false;
        			}
        		}
        		try{
        			iframeErrorsBody = iframeErrors.body; 
        			setTimeout(function(){
        				isErrorIFrame(obj);
        			},3000)
        		} catch(e) {
        			diaFrame = jQuery("<div/>").dialog({
                        id: 'dialogiFrameError',
                        modal: false,
                        title: 'Error',
                        resizable: 'auto',
                        autoOpen: true 
                    }).parent().find(".ui-dialog-titlebar-close").show().end().end();
                    jQuery("<div/>").addClass("ui-progressbar-indicator").text(msgErrorIframeDa).appendTo(diaFrame);
                        waitDialog.dialog("close");
        		}

        }
        /*RVSITEBUILDER MOD*/
        function cb(e) {
            if (xhr.aborted || callbackProcessed) {
                return;
            }
            try {
                doc = getDoc(io);
            }
            catch(ex) {
                log('cannot access response document: ', ex);
                e = SERVER_ABORT;
            }
            if (e === CLIENT_TIMEOUT_ABORT && xhr) {
                xhr.abort('timeout');
                return;
            }
            else if (e == SERVER_ABORT && xhr) {
                xhr.abort('server abort');
                return;
            }

            if (!doc || doc.location.href == s.iframeSrc) {
                // response not received yet
                if (!timedOut)
                    return;
            }
            if (io.detachEvent)
                io.detachEvent('onload', cb);
            else    
                io.removeEventListener('load', cb, false);

            var status = 'success', errMsg;
            try {
                if (timedOut) {
                    throw 'timeout';
                }

                var isXml = s.dataType == 'xml' || doc.XMLDocument || $.isXMLDoc(doc);
                log('isXml='+isXml);
                if (!isXml && window.opera && (doc.body === null || !doc.body.innerHTML)) {
                    if (--domCheckCount) {
                        // in some browsers (Opera) the iframe DOM is not always traversable when
                        // the onload callback fires, so we loop a bit to accommodate
                        log('requeing onLoad callback, DOM not available');
                        setTimeout(cb, 250);
                        return;
                    }
                    // let this fall through because server response could be an empty document
                    //log('Could not access iframe DOM after mutiple tries.');
                    //throw 'DOMException: not available';
                }
				/*RVSITEBUILDER MOD*/	
            	if(doc.getElementsByTagName('textarea')[1]) {
                xhr.responseText = doc.getElementsByTagName('textarea')[1].value 
                    ? doc.getElementsByTagName('textarea')[1].value 
                    : doc.body 
                        ? doc.body.innerHTML 
                        : null;
                xhr.responseXML = doc.XMLDocument ? doc.XMLDocument : doc;
                
                var responseHeader = doc.getElementsByTagName('textarea')[0].value 
                    ? doc.getElementsByTagName('textarea')[0].value 
                    : null;
                
                if (responseHeader == null) {                                    
                    xhr.getResponseHeader = function(header){

                        var headers = {'content-type': opts.dataType};
                        return headers[header];
                    };
                 }
                /*RVSITEBUILDER MOD*/
                } else {
                //log('response detected');
                var docRoot = doc.body ? doc.body : doc.documentElement;
                xhr.responseText = docRoot ? docRoot.innerHTML : null;
                xhr.responseXML = doc.XMLDocument ? doc.XMLDocument : doc;
                if (isXml)
                    s.dataType = 'xml';
                xhr.getResponseHeader = function(header){
                    var headers = {'content-type': s.dataType};
                    return headers[header];
                };
                }
                // support for XHR 'status' & 'statusText' emulation :
                if (docRoot) {
                    xhr.status = Number( docRoot.getAttribute('status') ) || xhr.status;
                    xhr.statusText = docRoot.getAttribute('statusText') || xhr.statusText;
                }

                var dt = (s.dataType || '').toLowerCase();
                var scr = /(json|script|text)/.test(dt);
                if (scr || s.textarea) {
                    // see if user embedded response in textarea
                    /*RVSITEBUILDER MOD*/
                    var ta = doc.getElementsByTagName('textarea')[1]
                        ? doc.getElementsByTagName('textarea')[1] 
                        :doc.getElementsByTagName('textarea')[0];
                 	/*RVSITEBUILDER MOD*/
                    if (ta) {
                        xhr.responseText = ta.value;
                        // support for XHR 'status' & 'statusText' emulation :
                        xhr.status = Number( ta.getAttribute('status') ) || xhr.status;
                        xhr.statusText = ta.getAttribute('statusText') || xhr.statusText;
                    }
                    else if (scr) {
                        // account for browsers injecting pre around json response
                        var pre = doc.getElementsByTagName('pre')[0];
                        var b = doc.getElementsByTagName('body')[0];
                        if (pre) {
                            xhr.responseText = pre.textContent ? pre.textContent : pre.innerText;
                        }
                        else if (b) {
                            xhr.responseText = b.textContent ? b.textContent : b.innerText;
                        }
                    }
                }
                else if (dt == 'xml' && !xhr.responseXML && xhr.responseText) {
                    xhr.responseXML = toXml(xhr.responseText);
                }

                try {
                    data = httpData(xhr, dt, s);
                }
                catch (e) {
                    status = 'parsererror';
                    xhr.error = errMsg = (e || status);
                }
            }
            catch (e) {
                log('error caught: ',e);
                status = 'error';
                xhr.error = errMsg = (e || status);
            }

            if (xhr.aborted) {
                log('upload aborted');
                status = null;
            }

            if (xhr.status) { // we've set xhr.status
                status = (xhr.status >= 200 && xhr.status < 300 || xhr.status === 304) ? 'success' : 'error';
            }
            /*RVSITEBUILDER MOD*/
            if (xhr.status != 200) ok = false;
            /*RVSITEBUILDER MOD*/

            // ordering of these callbacks/triggers is odd, but that's how $.ajax does it
            if (status === 'success') {
                if (s.success)
                    s.success.call(s.context, data, 'success', xhr);
                if (g)
                    $.event.trigger("ajaxSuccess", [xhr, s]);
            }
            else if (status) {
                if (errMsg === undefined)
                    errMsg = xhr.statusText;
                if (s.error)
                    s.error.call(s.context, xhr, status, errMsg);
                if (g)
                    $.event.trigger("ajaxError", [xhr, s, errMsg]);
            }

            if (g)
                $.event.trigger("ajaxComplete", [xhr, s]);

            if (g && ! --$.active) {
                $.event.trigger("ajaxStop");
            }

            if (s.complete)
                s.complete.call(s.context, xhr, status);

            callbackProcessed = true;
            if (s.timeout)
                clearTimeout(timeoutHandle);

            // clean up
            setTimeout(function() {
                if (!s.iframeTarget)
                    $io.remove();
                xhr.responseXML = null;
            }, 100);
        }

        var toXml = $.parseXML || function(s, doc) { // use parseXML if available (jQuery 1.5+)
            if (window.ActiveXObject) {
                doc = new ActiveXObject('Microsoft.XMLDOM');
                doc.async = 'false';
                doc.loadXML(s);
            }
            else {
                doc = (new DOMParser()).parseFromString(s, 'text/xml');
            }
            return (doc && doc.documentElement && doc.documentElement.nodeName != 'parsererror') ? doc : null;
        };
        var parseJSON = $.parseJSON || function(s) {
            /*jslint evil:true */
            return window['eval']('(' + s + ')');
        };

        var httpData = function( xhr, type, s ) { // mostly lifted from jq1.4.4

            var ct = xhr.getResponseHeader('content-type') || '',
                xml = type === 'xml' || !type && ct.indexOf('xml') >= 0,
                data = xml ? xhr.responseXML : xhr.responseText;

            if (xml && data.documentElement.nodeName === 'parsererror') {
                if ($.error)
                    $.error('parsererror');
            }
            if (s && s.dataFilter) {
                data = s.dataFilter(data, type);
            }
            if (typeof data === 'string') {
                if (type === 'json' || !type && ct.indexOf('json') >= 0) {
                    data = parseJSON(data);
                } else if (type === "script" || !type && ct.indexOf("javascript") >= 0) {
                    $.globalEval(data);
                }
            }
            return data;
        };
    }
};

/**
 * ajaxForm() provides a mechanism for fully automating form submission.
 *
 * The advantages of using this method instead of ajaxSubmit() are:
 *
 * 1: This method will include coordinates for <input type="image" /> elements (if the element
 *    is used to submit the form).
 * 2. This method will include the submit element's name/value data (for the element that was
 *    used to submit the form).
 * 3. This method binds the submit() method to the form for you.
 *
 * The options argument for ajaxForm works exactly as it does for ajaxSubmit.  ajaxForm merely
 * passes the options argument along after properly binding events for submit elements and
 * the form itself.
 */
$.fn.ajaxForm = function(options) {
    options = options || {};
    options.delegation = options.delegation && $.isFunction($.fn.on);
    
    // in jQuery 1.3+ we can fix mistakes with the ready state
    if (!options.delegation && this.length === 0) {
        var o = { s: this.selector, c: this.context };
        if (!$.isReady && o.s) {
            log('DOM not ready, queuing ajaxForm');
            $(function() {
                $(o.s,o.c).ajaxForm(options);
            });
            return this;
        }
        // is your DOM ready?  http://docs.jquery.com/Tutorials:Introducing_$(document).ready()
        log('terminating; zero elements found by selector' + ($.isReady ? '' : ' (DOM not ready)'));
        return this;
    }

    if ( options.delegation ) {
        $(document)
            .off('submit.form-plugin', this.selector, doAjaxSubmit)
            .off('click.form-plugin', this.selector, captureSubmittingElement)
            .on('submit.form-plugin', this.selector, options, doAjaxSubmit)
            .on('click.form-plugin', this.selector, options, captureSubmittingElement);
        return this;
    }

    return this.ajaxFormUnbind()
        .bind('submit.form-plugin', options, doAjaxSubmit)
        .bind('click.form-plugin', options, captureSubmittingElement)
        /*
        .each(function() {
        // store options in hash
        $(":submit,input:image", this).bind('click.form-plugin',function(e) {
            var form = this.form;
            form.clk = this;
            if (this.type == 'image') {
                if (e.offsetX != undefined) {
                    form.clk_x = e.offsetX;
                    form.clk_y = e.offsetY;
                } else if (typeof $.fn.offset == 'function') { // try to use dimensions plugin
                    var offset = $(this).offset();
                    form.clk_x = e.pageX - offset.left;
                    form.clk_y = e.pageY - offset.top;
                } else {
                    form.clk_x = e.pageX - this.offsetLeft;
                    form.clk_y = e.pageY - this.offsetTop;
                }
            }
            // clear form vars
            setTimeout(function() { form.clk = form.clk_x = form.clk_y = null; }, 10);
        });
    })
    */
    ;

};

// private event handlers    
function doAjaxSubmit(e) {
    /*jshint validthis:true */
    var options = e.data;
    if (!e.isDefaultPrevented()) { // if event has been canceled, don't proceed
        e.preventDefault();
        $(this).ajaxSubmit(options);
    }
}
    
function captureSubmittingElement(e) {
    /*jshint validthis:true */
    var target = e.target;
    var $el = $(target);
    if (!($el.is(":submit,input:image"))) {
        // is this a child element of the submit el?  (ex: a span within a button)
        var t = $el.closest(':submit');
        if (t.length === 0) {
            return;
        }
        target = t[0];
    }
    var form = this;
    form.clk = target;
    if (target.type == 'image') {
        if (e.offsetX !== undefined) {
            form.clk_x = e.offsetX;
            form.clk_y = e.offsetY;
        } else if (typeof $.fn.offset == 'function') {
            var offset = $el.offset();
            form.clk_x = e.pageX - offset.left;
            form.clk_y = e.pageY - offset.top;
        } else {
            form.clk_x = e.pageX - target.offsetLeft;
            form.clk_y = e.pageY - target.offsetTop;
        }
    }
    // clear form vars
    setTimeout(function() { form.clk = form.clk_x = form.clk_y = null; }, 100);
}


// ajaxFormUnbind unbinds the event handlers that were bound by ajaxForm
$.fn.ajaxFormUnbind = function() {
    return this.unbind('submit.form-plugin click.form-plugin');
};

/**
 * formToArray() gathers form element data into an array of objects that can
 * be passed to any of the following ajax functions: $.get, $.post, or load.
 * Each object in the array has both a 'name' and 'value' property.  An example of
 * an array for a simple login form might be:
 *
 * [ { name: 'username', value: 'jresig' }, { name: 'password', value: 'secret' } ]
 *
 * It is this array that is passed to pre-submit callback functions provided to the
 * ajaxSubmit() and ajaxForm() methods.
 */
$.fn.formToArray = function(semantic, elements) {
    var a = [];
    if (this.length === 0) {
        return a;
    }

    var form = this[0];
    var els = semantic ? form.getElementsByTagName('*') : form.elements;
    if (!els) {
        return a;
    }

    var i,j,n,v,el,max,jmax;
    for(i=0, max=els.length; i < max; i++) {
        el = els[i];
        n = el.name;
        if (!n) {
            continue;
        }

        if (semantic && form.clk && el.type == "image") {
            // handle image inputs on the fly when semantic == true
            if(!el.disabled && form.clk == el) {
                a.push({name: n, value: $(el).val(), type: el.type });
                a.push({name: n+'.x', value: form.clk_x}, {name: n+'.y', value: form.clk_y});
            }
            continue;
        }

        v = $.fieldValue(el, true);
        if (v && v.constructor == Array) {
            if (elements) 
                elements.push(el);
            for(j=0, jmax=v.length; j < jmax; j++) {
                a.push({name: n, value: v[j]});
            }
        }
        else if (feature.fileapi && el.type == 'file' && !el.disabled) {
            if (elements) 
                elements.push(el);
            var files = el.files;
            if (files.length) {
                for (j=0; j < files.length; j++) {
                    a.push({name: n, value: files[j], type: el.type});
                }
            }
            else {
                // #180
                a.push({ name: n, value: '', type: el.type });
            }
        }
        else if (v !== null && typeof v != 'undefined') {
            if (elements) 
                elements.push(el);
            a.push({name: n, value: v, type: el.type, required: el.required});
        }
    }

    if (!semantic && form.clk) {
        // input type=='image' are not found in elements array! handle it here
        var $input = $(form.clk), input = $input[0];
        n = input.name;
        if (n && !input.disabled && input.type == 'image') {
            a.push({name: n, value: $input.val()});
            a.push({name: n+'.x', value: form.clk_x}, {name: n+'.y', value: form.clk_y});
        }
    }
    return a;
};

/**
 * Serializes form data into a 'submittable' string. This method will return a string
 * in the format: name1=value1&amp;name2=value2
 */
$.fn.formSerialize = function(semantic) {
    //hand off to jQuery.param for proper encoding
    return $.param(this.formToArray(semantic));
};

/**
 * Serializes all field elements in the jQuery object into a query string.
 * This method will return a string in the format: name1=value1&amp;name2=value2
 */
$.fn.fieldSerialize = function(successful) {
    var a = [];
    this.each(function() {
        var n = this.name;
        if (!n) {
            return;
        }
        var v = $.fieldValue(this, successful);
        if (v && v.constructor == Array) {
            for (var i=0,max=v.length; i < max; i++) {
                a.push({name: n, value: v[i]});
            }
        }
        else if (v !== null && typeof v != 'undefined') {
            a.push({name: this.name, value: v});
        }
    });
    //hand off to jQuery.param for proper encoding
    return $.param(a);
};

/**
 * Returns the value(s) of the element in the matched set.  For example, consider the following form:
 *
 *  <form><fieldset>
 *      <input name="A" type="text" />
 *      <input name="A" type="text" />
 *      <input name="B" type="checkbox" value="B1" />
 *      <input name="B" type="checkbox" value="B2"/>
 *      <input name="C" type="radio" value="C1" />
 *      <input name="C" type="radio" value="C2" />
 *  </fieldset></form>
 *
 *  var v = $(':text').fieldValue();
 *  // if no values are entered into the text inputs
 *  v == ['','']
 *  // if values entered into the text inputs are 'foo' and 'bar'
 *  v == ['foo','bar']
 *
 *  var v = $(':checkbox').fieldValue();
 *  // if neither checkbox is checked
 *  v === undefined
 *  // if both checkboxes are checked
 *  v == ['B1', 'B2']
 *
 *  var v = $(':radio').fieldValue();
 *  // if neither radio is checked
 *  v === undefined
 *  // if first radio is checked
 *  v == ['C1']
 *
 * The successful argument controls whether or not the field element must be 'successful'
 * (per http://www.w3.org/TR/html4/interact/forms.html#successful-controls).
 * The default value of the successful argument is true.  If this value is false the value(s)
 * for each element is returned.
 *
 * Note: This method *always* returns an array.  If no valid value can be determined the
 *    array will be empty, otherwise it will contain one or more values.
 */
$.fn.fieldValue = function(successful) {
    for (var val=[], i=0, max=this.length; i < max; i++) {
        var el = this[i];
        var v = $.fieldValue(el, successful);
        if (v === null || typeof v == 'undefined' || (v.constructor == Array && !v.length)) {
            continue;
        }
        if (v.constructor == Array)
            $.merge(val, v);
        else
            val.push(v);
    }
    return val;
};

/**
 * Returns the value of the field element.
 */
$.fieldValue = function(el, successful) {
    var n = el.name, t = el.type, tag = el.tagName.toLowerCase();
    if (successful === undefined) {
        successful = true;
    }

    if (successful && (!n || el.disabled || t == 'reset' || t == 'button' ||
        (t == 'checkbox' || t == 'radio') && !el.checked ||
        (t == 'submit' || t == 'image') && el.form && el.form.clk != el ||
        tag == 'select' && el.selectedIndex == -1)) {
            return null;
    }

    if (tag == 'select') {
        var index = el.selectedIndex;
        if (index < 0) {
            return null;
        }
        var a = [], ops = el.options;
        var one = (t == 'select-one');
        var max = (one ? index+1 : ops.length);
        for(var i=(one ? index : 0); i < max; i++) {
            var op = ops[i];
            if (op.selected) {
                var v = op.value;
                if (!v) { // extra pain for IE...
                    v = (op.attributes && op.attributes['value'] && !(op.attributes['value'].specified)) ? op.text : op.value;
                }
                if (one) {
                    return v;
                }
                a.push(v);
            }
        }
        return a;
    }
    return $(el).val();
};

/**
 * Clears the form data.  Takes the following actions on the form's input fields:
 *  - input text fields will have their 'value' property set to the empty string
 *  - select elements will have their 'selectedIndex' property set to -1
 *  - checkbox and radio inputs will have their 'checked' property set to false
 *  - inputs of type submit, button, reset, and hidden will *not* be effected
 *  - button elements will *not* be effected
 */
$.fn.clearForm = function(includeHidden) {
    return this.each(function() {
        $('input,select,textarea', this).clearFields(includeHidden);
    });
};

/**
 * Clears the selected form elements.
 */
$.fn.clearFields = $.fn.clearInputs = function(includeHidden) {
    var re = /^(?:color|date|datetime|email|month|number|password|range|search|tel|text|time|url|week)$/i; // 'hidden' is not in this list
    return this.each(function() {
        var t = this.type, tag = this.tagName.toLowerCase();
        if (re.test(t) || tag == 'textarea') {
            this.value = '';
        }
        else if (t == 'checkbox' || t == 'radio') {
            this.checked = false;
        }
        else if (tag == 'select') {
            this.selectedIndex = -1;
        }
        else if (includeHidden) {
            // includeHidden can be the valud true, or it can be a selector string
            // indicating a special test; for example:
            //  $('#myForm').clearForm('.special:hidden')
            // the above would clean hidden inputs that have the class of 'special'
            if ( (includeHidden === true && /hidden/.test(t)) ||
                 (typeof includeHidden == 'string' && $(this).is(includeHidden)) )
                this.value = '';
        }
    });
};

/**
 * Resets the form data.  Causes all form elements to be reset to their original value.
 */
$.fn.resetForm = function() {
    return this.each(function() {
        // guard against an input with the name of 'reset'
        // note that IE reports the reset function as an 'object'
        if (typeof this.reset == 'function' || (typeof this.reset == 'object' && !this.reset.nodeType)) {
            this.reset();
        }
    });
};

/**
 * Enables or disables any matching elements.
 */
$.fn.enable = function(b) {
    if (b === undefined) {
        b = true;
    }
    return this.each(function() {
        this.disabled = !b;
    });
};

/**
 * Checks/unchecks any matching checkboxes or radio buttons and
 * selects/deselects and matching option elements.
 */
$.fn.selected = function(select) {
    if (select === undefined) {
        select = true;
    }
    return this.each(function() {
        var t = this.type;
        if (t == 'checkbox' || t == 'radio') {
            this.checked = select;
        }
        else if (this.tagName.toLowerCase() == 'option') {
            var $sel = $(this).parent('select');
            if (select && $sel[0] && $sel[0].type == 'select-one') {
                // deselect all other options
                $sel.find('option').selected(false);
            }
            this.selected = select;
        }
    });
};

// expose debug var
$.fn.ajaxSubmit.debug = false;

// helper fn for console logging
function log() {
    if (!$.fn.ajaxSubmit.debug) 
        return;
    var msg = '[jquery.form] ' + Array.prototype.join.call(arguments,'');
    if (window.console && window.console.log) {
        window.console.log(msg);
    }
    else if (window.opera && window.opera.postError) {
        window.opera.postError(msg);
    }
}

})(jQuery);
	/**
	 * jQuery MD5 hash algorithm function
	 * 
	 * 	<code>
	 * 		Calculate the md5 hash of a String 
	 * 		String $.md5 ( String str )
	 * 	</code>
	 * 
	 * Calculates the MD5 hash of str using the Â» RSA Data Security, Inc. MD5 Message-Digest Algorithm, and returns that hash. 
	 * MD5 (Message-Digest algorithm 5) is a widely-used cryptographic hash function with a 128-bit hash value. MD5 has been employed in a wide variety of security applications, and is also commonly used to check the integrity of data. The generated hash is also non-reversable. Data cannot be retrieved from the message digest, the digest uniquely identifies the data.
	 * MD5 was developed by Professor Ronald L. Rivest in 1994. Its 128 bit (16 byte) message digest makes it a faster implementation than SHA-1.
	 * This script is used to process a variable length message into a fixed-length output of 128 bits using the MD5 algorithm. It is fully compatible with UTF-8 encoding. It is very useful when u want to transfer encrypted passwords over the internet. If you plan using UTF-8 encoding in your project don't forget to set the page encoding to UTF-8 (Content-Type meta tag). 
	 * This function orginally get from the WebToolkit and rewrite for using as the jQuery plugin.
	 * 
	 * Example
	 * 	Code
	 * 		<code>
	 * 			$.md5("I'm Persian."); 
	 * 		</code>
	 * 	Result
	 * 		<code>
	 * 			"b8c901d0f02223f9761016cfff9d68df"
	 * 		</code>
	 * 
	 * @alias Muhammad Hussein Fattahizadeh < muhammad [AT] semnanweb [DOT] com >
	 * @link http://www.semnanweb.com/jquery-plugin/md5.html
	 * @see http://www.webtoolkit.info/
	 * @license http://www.gnu.org/licenses/gpl.html [GNU General Public License]
	 * @param {jQuery} {md5:function(string))
	 * @return string
	 */
	
	(function($){
		
		var rotateLeft = function(lValue, iShiftBits) {
			return (lValue << iShiftBits) | (lValue >>> (32 - iShiftBits));
		}
		
		var addUnsigned = function(lX, lY) {
			var lX4, lY4, lX8, lY8, lResult;
			lX8 = (lX & 0x80000000);
			lY8 = (lY & 0x80000000);
			lX4 = (lX & 0x40000000);
			lY4 = (lY & 0x40000000);
			lResult = (lX & 0x3FFFFFFF) + (lY & 0x3FFFFFFF);
			if (lX4 & lY4) return (lResult ^ 0x80000000 ^ lX8 ^ lY8);
			if (lX4 | lY4) {
				if (lResult & 0x40000000) return (lResult ^ 0xC0000000 ^ lX8 ^ lY8);
				else return (lResult ^ 0x40000000 ^ lX8 ^ lY8);
			} else {
				return (lResult ^ lX8 ^ lY8);
			}
		}
		
		var F = function(x, y, z) {
			return (x & y) | ((~ x) & z);
		}
		
		var G = function(x, y, z) {
			return (x & z) | (y & (~ z));
		}
		
		var H = function(x, y, z) {
			return (x ^ y ^ z);
		}
		
		var I = function(x, y, z) {
			return (y ^ (x | (~ z)));
		}
		
		var FF = function(a, b, c, d, x, s, ac) {
			a = addUnsigned(a, addUnsigned(addUnsigned(F(b, c, d), x), ac));
			return addUnsigned(rotateLeft(a, s), b);
		};
		
		var GG = function(a, b, c, d, x, s, ac) {
			a = addUnsigned(a, addUnsigned(addUnsigned(G(b, c, d), x), ac));
			return addUnsigned(rotateLeft(a, s), b);
		};
		
		var HH = function(a, b, c, d, x, s, ac) {
			a = addUnsigned(a, addUnsigned(addUnsigned(H(b, c, d), x), ac));
			return addUnsigned(rotateLeft(a, s), b);
		};
		
		var II = function(a, b, c, d, x, s, ac) {
			a = addUnsigned(a, addUnsigned(addUnsigned(I(b, c, d), x), ac));
			return addUnsigned(rotateLeft(a, s), b);
		};
		
		var convertToWordArray = function(string) {
			var lWordCount;
			var lMessageLength = string.length;
			var lNumberOfWordsTempOne = lMessageLength + 8;
			var lNumberOfWordsTempTwo = (lNumberOfWordsTempOne - (lNumberOfWordsTempOne % 64)) / 64;
			var lNumberOfWords = (lNumberOfWordsTempTwo + 1) * 16;
			var lWordArray = Array(lNumberOfWords - 1);
			var lBytePosition = 0;
			var lByteCount = 0;
			while (lByteCount < lMessageLength) {
				lWordCount = (lByteCount - (lByteCount % 4)) / 4;
				lBytePosition = (lByteCount % 4) * 8;
				lWordArray[lWordCount] = (lWordArray[lWordCount] | (string.charCodeAt(lByteCount) << lBytePosition));
				lByteCount++;
			}
			lWordCount = (lByteCount - (lByteCount % 4)) / 4;
			lBytePosition = (lByteCount % 4) * 8;
			lWordArray[lWordCount] = lWordArray[lWordCount] | (0x80 << lBytePosition);
			lWordArray[lNumberOfWords - 2] = lMessageLength << 3;
			lWordArray[lNumberOfWords - 1] = lMessageLength >>> 29;
			return lWordArray;
		};
		
		var wordToHex = function(lValue) {
			var WordToHexValue = "", WordToHexValueTemp = "", lByte, lCount;
			for (lCount = 0; lCount <= 3; lCount++) {
				lByte = (lValue >>> (lCount * 8)) & 255;
				WordToHexValueTemp = "0" + lByte.toString(16);
				WordToHexValue = WordToHexValue + WordToHexValueTemp.substr(WordToHexValueTemp.length - 2, 2);
			}
			return WordToHexValue;
		};
		
		var uTF8Encode = function(string) {
			string = string.replace(/\x0d\x0a/g, "\x0a");
			var output = "";
			for (var n = 0; n < string.length; n++) {
				var c = string.charCodeAt(n);
				if (c < 128) {
					output += String.fromCharCode(c);
				} else if ((c > 127) && (c < 2048)) {
					output += String.fromCharCode((c >> 6) | 192);
					output += String.fromCharCode((c & 63) | 128);
				} else {
					output += String.fromCharCode((c >> 12) | 224);
					output += String.fromCharCode(((c >> 6) & 63) | 128);
					output += String.fromCharCode((c & 63) | 128);
				}
			}
			return output;
		};
		
		$.extend({
			md5: function(string) {
				var x = Array();
				var k, AA, BB, CC, DD, a, b, c, d;
				var S11=7, S12=12, S13=17, S14=22;
				var S21=5, S22=9 , S23=14, S24=20;
				var S31=4, S32=11, S33=16, S34=23;
				var S41=6, S42=10, S43=15, S44=21;
				string = uTF8Encode(string);
				x = convertToWordArray(string);
				a = 0x67452301; b = 0xEFCDAB89; c = 0x98BADCFE; d = 0x10325476;
				for (k = 0; k < x.length; k += 16) {
					AA = a; BB = b; CC = c; DD = d;
					a = FF(a, b, c, d, x[k+0],  S11, 0xD76AA478);
					d = FF(d, a, b, c, x[k+1],  S12, 0xE8C7B756);
					c = FF(c, d, a, b, x[k+2],  S13, 0x242070DB);
					b = FF(b, c, d, a, x[k+3],  S14, 0xC1BDCEEE);
					a = FF(a, b, c, d, x[k+4],  S11, 0xF57C0FAF);
					d = FF(d, a, b, c, x[k+5],  S12, 0x4787C62A);
					c = FF(c, d, a, b, x[k+6],  S13, 0xA8304613);
					b = FF(b, c, d, a, x[k+7],  S14, 0xFD469501);
					a = FF(a, b, c, d, x[k+8],  S11, 0x698098D8);
					d = FF(d, a, b, c, x[k+9],  S12, 0x8B44F7AF);
					c = FF(c, d, a, b, x[k+10], S13, 0xFFFF5BB1);
					b = FF(b, c, d, a, x[k+11], S14, 0x895CD7BE);
					a = FF(a, b, c, d, x[k+12], S11, 0x6B901122);
					d = FF(d, a, b, c, x[k+13], S12, 0xFD987193);
					c = FF(c, d, a, b, x[k+14], S13, 0xA679438E);
					b = FF(b, c, d, a, x[k+15], S14, 0x49B40821);
					a = GG(a, b, c, d, x[k+1],  S21, 0xF61E2562);
					d = GG(d, a, b, c, x[k+6],  S22, 0xC040B340);
					c = GG(c, d, a, b, x[k+11], S23, 0x265E5A51);
					b = GG(b, c, d, a, x[k+0],  S24, 0xE9B6C7AA);
					a = GG(a, b, c, d, x[k+5],  S21, 0xD62F105D);
					d = GG(d, a, b, c, x[k+10], S22, 0x2441453);
					c = GG(c, d, a, b, x[k+15], S23, 0xD8A1E681);
					b = GG(b, c, d, a, x[k+4],  S24, 0xE7D3FBC8);
					a = GG(a, b, c, d, x[k+9],  S21, 0x21E1CDE6);
					d = GG(d, a, b, c, x[k+14], S22, 0xC33707D6);
					c = GG(c, d, a, b, x[k+3],  S23, 0xF4D50D87);
					b = GG(b, c, d, a, x[k+8],  S24, 0x455A14ED);
					a = GG(a, b, c, d, x[k+13], S21, 0xA9E3E905);
					d = GG(d, a, b, c, x[k+2],  S22, 0xFCEFA3F8);
					c = GG(c, d, a, b, x[k+7],  S23, 0x676F02D9);
					b = GG(b, c, d, a, x[k+12], S24, 0x8D2A4C8A);
					a = HH(a, b, c, d, x[k+5],  S31, 0xFFFA3942);
					d = HH(d, a, b, c, x[k+8],  S32, 0x8771F681);
					c = HH(c, d, a, b, x[k+11], S33, 0x6D9D6122);
					b = HH(b, c, d, a, x[k+14], S34, 0xFDE5380C);
					a = HH(a, b, c, d, x[k+1],  S31, 0xA4BEEA44);
					d = HH(d, a, b, c, x[k+4],  S32, 0x4BDECFA9);
					c = HH(c, d, a, b, x[k+7],  S33, 0xF6BB4B60);
					b = HH(b, c, d, a, x[k+10], S34, 0xBEBFBC70);
					a = HH(a, b, c, d, x[k+13], S31, 0x289B7EC6);
					d = HH(d, a, b, c, x[k+0],  S32, 0xEAA127FA);
					c = HH(c, d, a, b, x[k+3],  S33, 0xD4EF3085);
					b = HH(b, c, d, a, x[k+6],  S34, 0x4881D05);
					a = HH(a, b, c, d, x[k+9],  S31, 0xD9D4D039);
					d = HH(d, a, b, c, x[k+12], S32, 0xE6DB99E5);
					c = HH(c, d, a, b, x[k+15], S33, 0x1FA27CF8);
					b = HH(b, c, d, a, x[k+2],  S34, 0xC4AC5665);
					a = II(a, b, c, d, x[k+0],  S41, 0xF4292244);
					d = II(d, a, b, c, x[k+7],  S42, 0x432AFF97);
					c = II(c, d, a, b, x[k+14], S43, 0xAB9423A7);
					b = II(b, c, d, a, x[k+5],  S44, 0xFC93A039);
					a = II(a, b, c, d, x[k+12], S41, 0x655B59C3);
					d = II(d, a, b, c, x[k+3],  S42, 0x8F0CCC92);
					c = II(c, d, a, b, x[k+10], S43, 0xFFEFF47D);
					b = II(b, c, d, a, x[k+1],  S44, 0x85845DD1);
					a = II(a, b, c, d, x[k+8],  S41, 0x6FA87E4F);
					d = II(d, a, b, c, x[k+15], S42, 0xFE2CE6E0);
					c = II(c, d, a, b, x[k+6],  S43, 0xA3014314);
					b = II(b, c, d, a, x[k+13], S44, 0x4E0811A1);
					a = II(a, b, c, d, x[k+4],  S41, 0xF7537E82);
					d = II(d, a, b, c, x[k+11], S42, 0xBD3AF235);
					c = II(c, d, a, b, x[k+2],  S43, 0x2AD7D2BB);
					b = II(b, c, d, a, x[k+9],  S44, 0xEB86D391);
					a = addUnsigned(a, AA);
					b = addUnsigned(b, BB);
					c = addUnsigned(c, CC);
					d = addUnsigned(d, DD);
				}
				var tempValue = wordToHex(a) + wordToHex(b) + wordToHex(c) + wordToHex(d);
				return tempValue.toLowerCase();
			}
		});
	})(jQuery);/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// WebSite:  http://www.rvglobalsoft.com
// Unauthorized copying is strictly forbidden and may result in severe legal action.
// Copyright (c) 2006 RV Global Soft Co.,Ltd. All rights reserved.
// 
// =====YOU MUST KEEP THIS COPYRIGHTS NOTICE INTACT AND CAN NOT BE REMOVE =======
// Copyright (c) 2006 RV Global Soft Co.,Ltd. All rights reserved.
// This Agreement is a legal contract, which specifies the terms of the license
// and warranty limitation between you and RV Global Soft Co.,Ltd. and RV Site Builder.
// You should carefully read the following terms and conditions before
// installing or using this software.  Unless you have a different license
// agreement obtained from RV Global Soft Co.,Ltd., installation or use of this software
// indicates your acceptance of the license and warranty limitation terms
// contained in this Agreement. If you do not agree to the terms of this
// Agreement, promptly delete and destroy all copies of the Software.
//
// =====  Grant of License =======
// The Software may only be installed and used on a single host machine.
//
// =====  Disclaimer of Warranty =======
// THIS SOFTWARE AND ACCOMPANYING DOCUMENTATION ARE PROVIDED "AS IS" AND
// WITHOUT WARRANTIES AS TO PERFORMANCE OF MERCHANTABILITY OR ANY OTHER
// WARRANTIES WHETHER EXPRESSED OR IMPLIED.   BECAUSE OF THE VARIOUS HARDWARE
// AND SOFTWARE ENVIRONMENTS INTO WHICH RV SITE BUILDER MAY BE USED, NO WARRANTY OF
// FITNESS FOR A PARTICULAR PURPOSE IS OFFERED.  THE USER MUST ASSUME THE
// ENTIRE RISK OF USING THIS PROGRAM.  ANY LIABILITY OF RV GLOBAL SOFT CO.,LTD. WILL BE
// LIMITED EXCLUSIVELY TO PRODUCT REPLACEMENT OR REFUND OF PURCHASE PRICE.
// IN NO CASE SHALL RV GLOBAL SOFT CO.,LTD. BE LIABLE FOR ANY INCIDENTAL, SPECIAL OR
// CONSEQUENTIAL DAMAGES OR LOSS, INCLUDING, WITHOUT LIMITATION, LOST PROFITS
// OR THE INABILITY TO USE EQUIPMENT OR ACCESS DATA, WHETHER SUCH DAMAGES ARE
// BASED UPON A BREACH OF EXPRESS OR IMPLIED WARRANTIES, BREACH OF CONTRACT,
// NEGLIGENCE, STRICT TORT, OR ANY OTHER LEGAL THEORY. THIS IS TRUE EVEN IF
// RV GLOBAL SOFT CO.,LTD. IS ADVISED OF THE POSSIBILITY OF SUCH DAMAGES. IN NO CASE WILL
// RV GLOBAL SOFT CO.,LTD.'S LIABILITY EXCEED THE AMOUNT OF THE LICENSE FEE ACTUALLY PAID
// BY LICENSEE TO RV GLOBAL SOFT CO.,LTD.
// +---------------------------------------------------------------------------+
// $Id: sitebuilder.js,v 1.1 2007/07/06 06:52:41 parinya Exp $
// +---------------------------------------------------------------------------+


/**
 * Main Java Script for sitebuilder
 *
 * @package sitebuilder
 * @author Pairote <pairote@rvglobalsoft.com>
 * @author Parinya <parinya@rvglobalsoft.com>
 * @version $Revision: 1.1 $
 * 
 * Depends:
 *  jquery.js
 *  ui.dialog.js (jQuery)
 *  ui.core.js (jQuery)
 *  ui.draggable.js (jQuery)
 *  ui.resizable.js (jQuery)
 *  jquery.bgiframe.js (jQuery)
 *  plugins/labs_json.js (jQuery)
 *  plugins/jquery.form.js (jQuery)
 *  prototype.js
 */

if (window.jQuery && !window.jQuery.sitebuilder) {
    var LOG_PRIORITY = {
            ALERT: 0,
            CRIT: 1,
            ERR: 2,
            WARNING: 3,
            NOTICE: 4,
            INFO: 5,
            DEBUG: 6
    };
    
    (function(jQuery) {
        
        jQuery.sitebuilder = { };
        jQuery.sitebuilder.string = {
        		wordwrap: function(text, width, brk, cut) {
        	
		            brk = brk || '\n';
		            width = width || 75;
		            cut = cut || false;
		            
		            if (!text) { return text; }
		            text = jQuery.trim(text);
		            var i, j, s, r = text.split("\n");
		            if(width > 0) for(i in r){
		                for(s = r[i], r[i] = ""; s.length > width;
		                    j = cut ? width : (j = s.substr(0, width).match(/\S*$/)).input.length - j[0].length
		                    || width,
		                    r[i] += s.substr(0, j) + ((s = s.substr(j)).length ? brk : "")
		                );
		                r[i] += s;
		            }
		            
		            return r.join("\n");
        		},
                decode: function(data) {
                    return     (typeof data =='object')? data:jQuery.json.decode(data);
            }

        		
        		
        };
        jQuery.sitebuilder.Log = {
                logMessage: function(message, level) {
                    if(window.console && !SGL_PRODUCTION) {
                        if(!document.all) {
                    	console.debug(jQuery.sitebuilder.Log.getLogLevelMsg(level) + ': ' + message);
                    
                        }
                    }
                    return this;
                },
                getLogLevelMsg: function(level) {
                    switch (level) {
                        case LOG_PRIORITY.ALERT: return 'Alert';
                        case LOG_PRIORITY.CRIT: return 'Crit';
                        case LOG_PRIORITY.ERR: return 'Error';
                        case LOG_PRIORITY.WARNING: return 'Warning';
                        case LOG_PRIORITY.NOTICE: return 'Notice';
                        case LOG_PRIORITY.INFO: return 'Info';
                        case LOG_PRIORITY.DEBUG: 
                        default: return 'Debug';
                    };
                }
        };

        jQuery.sitebuilder.Ajax = {
            settingsdefault:  {
                /// Default setting
                type: "POST",
                url: RVS_AJAX_INDEX   
            },
            connect: function(param){
            	jQuery('body').css({'cursor':'wait'});
            	defaultSetting = {
            			type: "POST",
            			url: RVS_AJAX_INDEX   
            	};
            	
                if ( arguments.length === 2 ) {
                	/*
                    for (k in arguments[1]) {
                    	jQuery.sitebuilder.Log.logMessage('Dialog arguments Debug: ' + k, LOG_PRIORITY.DEBUG);
                    }
                    
                    for (k in defaultSetting) {
                    	jQuery.sitebuilder.Log.logMessage('Dialog defaultSetting Debug: ' + k, LOG_PRIORITY.DEBUG);
                    }
  */
                    settings = defaultSetting;
                    for (k in arguments[1]) {
                    	settings[k] = arguments[1][k];
                    }
                   // settings = jQuery.extend(settings, arguments[1]);
                    //if (this.settingsdefault.waitDialog != undefined) delete this.settingsdefault.waitDialog;
                }
                /*
                for (k in settings) {
                	jQuery.sitebuilder.Log.logMessage('Dialog settings Debug: ' + k, LOG_PRIORITY.DEBUG);
                }
                */
                

                if (settings.skipwaitDialog != undefined && settings.skipwaitDialog == true) {
                
                } else if (settings.waitDialog != undefined && typeof settings.waitDialog == "function") {
                	waitDialog = jQuery("<div/>");
                	waitDialog.bind(
                            "ajaxSend", function(){
                            	//alert('send')
                            	jQuery('body').css({'cursor':'wait'});
                            	if (settings.waitDialog == undefined) {
                            		if (typeof settings.waitDialog !== 'function') {
                                        jQuery('select,object,embed').displayTagProblemIE67('hidden'); 
                                       waitDialog.dialog('open');
                                   }
                            	} else {
                            		try{
                            			//alert(settings.waitDialog)
                            			settings.waitDialog("ajaxSend");
                            		} catch (e) {
                            		settings.waitDialog();
                            		}
                            	}
                            }
                        ).bind(
                            "ajaxComplete", function(){
                            	//jQuery('body').css({'cursor':'default'});
                            	if (settings.waitDialog == undefined) {
                            		jQuery('select,object,embed').displayTagProblemIE67('visible'); 
                                    waitDialog.dialog('close');
                                    waitDialog.dialog('destory');
                                    waitDialog.remove();
                            	} else {
                            		try{
                            			settings.waitDialog("ajaxComplete");
                            			 waitDialog.remove();
                            		} catch (e) {
                            			settings.waitDialog();
                            		}
                            	}
                            }
                        );
                } else {
                		
                    waitDialog = jQuery("<div/>").dialog({
                        modal: true,
                        title: "Please wait",
                        resizable: 'auto',
                        autoOpen: false
                    }).parent().find(".ui-dialog-titlebar-close").hide().end().end();
                    indicator = jQuery("<div/>").addClass("ui-progressbar-indicator").text("Please wait...").appendTo(waitDialog);
                    waitDialog.bind(
                        "ajaxSend", function(){
                        	jQuery('body').css({'cursor':'wait'});
                            if (typeof settings.waitDialog != 'function') {
                                 jQuery('select,object,embed').displayTagProblemIE67('hidden'); 
                                waitDialog.dialog('open');
                            } 
                        }
                    ).bind(
                        "ajaxComplete", function(event, XMLHttpRequest, ajaxOptions){ 
                        	//jQuery('body').css({'cursor':'default'});
                            if (typeof settings.waitDialog !== 'function') {
                                 jQuery('select,object,embed').displayTagProblemIE67('visible'); 
                                waitDialog.dialog('close');
                                waitDialog.dialog('destory');
                                waitDialog.remove();
                            }
                        }
                    );
                }
                
                jQuery.sitebuilder.Log.logMessage('AJAX Send: '+ param, LOG_PRIORITY.DEBUG);
                /// Setting AJAX
                jQuery.ajaxSetup(settings);
                /// Call AJAX
                
                
                option = {
                    success: function (data, textStatus){
                		jQuery('body').css({'cursor':'default'});
                        jQuery.sitebuilder.Log.logMessage('AJAX returns: '+ data, LOG_PRIORITY.DEBUG);
                        if (typeof settings.waitDialog === 'function') {
                        
                        } else {
                         jQuery('select,object,embed').displayTagProblemIE67('visible');
                            waitDialog.dialog('close');
                                waitDialog.dialog('destory');
                                waitDialog.remove();
                            }
                            //X-Powered-By Seagull http://seagullproject.org
                            //<hr /> <div id="errorWrapper" class="errorContent">
                		if(typeof data == 'object'){
                			if(typeof settings.callback.doSuccess == 'function') {
                                settings.callback.doSuccess(data);
                            } else {
                                jQuery.sitebuilder.Ajax.doSuccess(data);
                            }
                			
                		}else{
                			//alert('string')
                	
                            if ( (data.match(/^<hr \/>/gi) && data.match(/<div id="errorWrapper" class="errorContent">/gi)) 
                                 || data.match(/<span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>\( ! \)<\/span>/gi)
                            ) {
                                /// PHP Code error
                                ErrDialog = jQuery("<div/>").dialog({
                                    modal: true,
                                    title: 'PHP Error',
                                    width: 'auto',
                                    height: 'auto',
                                    resizable: 'auto',
                                    autoOpen: false,
                                       buttons:{
                                        "Close": function() { ErrDialog.dialog('close'); }
                                    }
                                }),
                                indicator = jQuery("<div/>").addClass("ui-progressbar-indicator").html(data).appendTo(ErrDialog);
                                ErrDialog.dialog('open');
                            } else if(typeof settings.callback.doSuccess == 'function') {

                                settings.callback.doSuccess(data);
                            } else {
                                jQuery.sitebuilder.Ajax.doSuccess(data);
                            }
                		}
                        },
                        error: function (xhr, ajaxOptions, thrownError){
                        	jQuery('body').css({'cursor':'default'});
                               /* for filefox
                               xhr.setRequestHeader 
                               xhr.send 
                               xhr.readyState 
                               xhr.status 
                               xhr.channel 
                               xhr.responseXML 
                               xhr.responseText 
                               xhr.statusText 
                               xhr.abort 
                               xhr.getAllResponseHeaders 
                               xhr.getResponseHeader 
                               xhr.sendAsBinary 
                               xhr.overrideMimeType 
                               xhr.multipart 
                               xhr.mozBackgroundRequest 
                               xhr.onload 
                               xhr.onerror 
                               xhr.onprogress 
                               xhr.onuploadprogress 
                               xhr.onreadystatechange 
                               xhr.addEventListener 
                               xhr.removeEventListener 
                               xhr.dispatchEvent 
                               xhr.getInterface 
                               */
                            keyy=''
                            for(key in xhr) {
                                keyy += key+'\n'
                              //  jQuery.sitebuilder.Log.logMessage('AJAX Error returns data: '+ key + " = " + eval("xhr."+key), LOG_PRIORITY.DEBUG)
                            }
                            var defXHR = {};
                            jQuery.sitebuilder.Log.logMessage('AJAX connect error '+ xhr.status +': '+ xhr.statusText, LOG_PRIORITY.ERR);
                            
                            if (typeof settings.waitDialog === 'function'){
                            
                            }else{
                                waitDialog.dialog('close');
                                waitDialog.dialog('destory');
                                waitDialog.remove();
                            }

                            if (xhr.status == 500) {
                                jQuery.sitebuilder.Log.logMessage('AJAX connect response text: '+xhr.responseText, LOG_PRIORITY.ERR);
    
                                ErrorJson = jQuery.json.decode(xhr.responseText);
                                defXHR = ErrorJson;
                                
                                if (ErrorJson.errorType != undefined && ErrorJson.errorType == "MGR") {
                                    defXHR.error = ErrorJson.error;
                                } else if (ErrorJson.errorType != undefined) {
                                    defXHR.errorMessage = ErrorJson.message;
                                } else {
                                    defXHR.errorType = 'UNK';
                                    defXHR.errorMessage = 'Unknown Status.';
                                }
                                
                            } else {
                                defXHR.errorMessage = 'Network connection Error(' + xhr.status + ': '+ xhr.statusText +'), please try again.';
                            }
                                
                            if (typeof settings.callback.doError === 'function') {
                                settings.callback.doError(xhr, ajaxOptions, thrownError,defXHR);
                            } else {
                                jQuery.sitebuilder.Ajax.doError(xhr, ajaxOptions, thrownError,defXHR);
                            }
                        }
                };
                
                if (param.match(/^[#|\.]/)) {
                    /// Send Form Id
                    jQuery.sitebuilder.Log.logMessage('Usage ajaxSubmit (jQuery form)', LOG_PRIORITY.ERR);
                    var mp = 'multipart/form-data';
                    jQuery(param).ajaxSubmit(option);
                } else {
                    jQuery.sitebuilder.Log.logMessage('Usage ajax (jQuery default)', LOG_PRIORITY.ERR);
                    option.data = param;
                    jQuery.ajax(option);
                }
                    /// Used data
            },
            doSuccess: function(data) {
                
                    /**
                     * Default process on event success.
                     * If want over write this function, you can setting callback in settings.doSuccess
                     */
            },
            doError: function(xhr, ajaxOptions, thrownError,defXHR) {
                 /**
                 * Default process on event error.
                 * If want over write this function, you can setting callback in settings.doError
                 */
                    try{
                    // try defXHR.error is string
                    var isdefXHRerror = eval('"'+defXHR.error+'"');
                    }catch(e){
                    //  defXHR.error is object
                    var isdefXHRerror = defXHR.error;
                    }
                if (defXHR.errorType === 'MGR') {
                    errorTitle = "Error";
                    errorText = '';
                    if(typeof isdefXHRerror === 'object') {
                        for (k in defXHR.error) {
                            errorText += defXHR.error[k];
                        }
                    } else {
                        errorText += defXHR.error
                    }
                    
                } else {
                    errorTitle = "System";
                    errorText = defXHR.errorMessage;    
                }
                    
                ErrDialog = jQuery(this).dialog({
                    modal: true,
                    title: errorTitle,
                    height: 'auto',
                    resizable: 'auto',
                    autoOpen: false,
                    buttons:{
                        "Close": function() { ErrDialog.dialog('close'); }
                    }
                });
                indicator = jQuery("<div/>").addClass("ui-progressbar-indicator").html(errorText).appendTo(ErrDialog);
           
            }
        };
        
        jQuery.sitebuilder.serialize = {
            form: function(Id) {
                var action;
                var settings = {};

                if ( arguments.length == 2 ) {
                    settings = arguments[1];
                }
                var inputParam = jQuery(Id + " input").serialize();
                var selectParam = jQuery(Id + " select").serialize();
                var textareaParam = jQuery(Id + " textarea").serialize();
                var resParam = '';
                
                if (selectParam != '') 
                    resParam += (resParam != '') ? '&' + selectParam : selectParam;

                if (inputParam != '') 
                    resParam += (resParam != '') ? '&' + inputParam : inputParam;
                
                if (textareaParam != '') 
                    resParam += (resParam != '') ? '&' + textareaParam : textareaParam;
                
                return resParam;
            }
        };
        
        jQuery.fn.rvsDialog = function() {
            var action;
            var settings = {};
            var SC_Settings = {};
            var parent;

            var defaultSettings = {
                bgiframe :false,
                modal: true,
                position: 'center',
                height: 'auto',
                width: 400,
                resizable: 'auto',
                draggable: true,
                closeOnEscape :true
            };
            
            if ( arguments.length == 1 ) {
                action = ( arguments[0].constructor == String ? arguments[0] : null );
                SC_Settings = ( arguments[0].constructor == Object ? arguments[0] : null );
            } else if ( arguments.length == 2 ) {
                action = ( arguments[0].constructor == String ? arguments[0] : null );
                SC_Settings = arguments[1];
            } else if ( arguments.length == 3 ) {
                action = ( arguments[0].constructor == String ? arguments[0] : null );
                optionVal = arguments[1];
                configOption = arguments[2];
            }

            return this.each(function(){
            	parent = jQuery(this).get(0).id;
                if (action === 'open') {
                    jQuery.sitebuilder.Log.logMessage('Open #'+ parent+' Dialog', LOG_PRIORITY.DEBUG);
                    var ie = jQuery(this);
                    ie.parent().find(".dialog-option").hide().end().end();
                    
                    settingInDesign = jQuery('#' + parent).find(".dialog-option").html();
                    
                  //  jQuery.sitebuilder.Log.logMessage('#'+ parent+' Dialog option:' + settingInDesign, LOG_PRIORITY.DEBUG);
                    
                    var DS_Setting = {};
                    if (settingInDesign != null) {
                        eval('DS_Setting = {' + settingInDesign + '};');
                    } 
                    settings = jQuery.extend(settings, defaultSettings);
                    settings = jQuery.extend(settings, DS_Setting);
                    settings = jQuery.extend(settings, SC_Settings);
       
                    
                    if(settings.modal == true ) {
                        if(jQuery.browser.msie && jQuery.browser.version < 7) {
                            jQuery('select,object,embed').displayTagProblemIE67('hidden'); 
                            var Optselect = ie.parent().find('select,object,embed');
                            for(i = 0; i < Optselect.length; i++){
                                jQuery(Optselect[i]).show();
                                jQuery.sitebuilder.Log.logMessage('select in Dialog : #'+ Optselect[i].id, LOG_PRIORITY.DEBUG);
                            }
                        }
                    }
                    
                     
                        settings.beforeclose = function(){
                        if (settings.doBeforeclose2) {
                             settings.doBeforeclose2();
                             }
                              jQuery('select,object,embed').displayTagProblemIE67('visible'); 
                        }
                    
                    
                    ie.dialog('option', 'autoOpen', false);
                    ie.dialog(settings);
                    ie.dialog('open').parent().find('.ui-dialog-buttonpane').css({'visibility':'visible'});
                    if (settings.closeOnEscape != true) {
                        // Close x button
                        ie.parent().find(".ui-dialog-titlebar-close").hide().end().end();
                    }
                } else if (action === 'close') {
                    jQuery.sitebuilder.Log.logMessage('Close #'+ parent +' Dialog', LOG_PRIORITY.DEBUG);
                    var ie = jQuery(this);
                    ie.dialog('close');
                    
                } else if (action === 'option') {
                    jQuery.sitebuilder.Log.logMessage('Close #'+ parent +' Dialog', LOG_PRIORITY.DEBUG);
                    var ie = jQuery(this);
                    ie.dialog('option',optionVal,configOption).parent().find('.ui-dialog-buttonpane').css({'visibility':'visible'});              
                }
            });
        };
        
        jQuery.fn.rvsTabs = function() {
         return this.each(function(){
             setTabs = jQuery(this);
         //    setTabs.tabs({ spinner: 'Retrieving data...' });
//             setTabs.tabs({ event: 'mouseover' });
 //good            setTabs.tabs({ fx: { opacity: 'toggle' } });
             //setTabs.tabs({ collapsible: true });
//             setTabs.tabs({ tabTemplate: '<div><a href="#{href}"><span>#{label}</span></a></div>' });
   //          setTabs.tabs({ deselectable: true });
         //    setTabs.tabs({ spinner: 'Retrieving data...' });
             setTabs.tabs().find(".ui-tabs-nav").sortable({axis:'x'})
             setTabs.tabs().tabs('option', 'fx', { opacity: 'toggle' });
             
         });
         };
        jQuery.fn.getSelectVal = function()
        {
            return jQuery(this).find('option:selected').text();
        }
        /*
        
        
        */
        jQuery.fn.convertHtmlToJs = function(data)
        {
            catchData = data;
                try{
                	if (typeof data != 'object') {
                		eval('data = ' + data);
                	}
                this.get(0).innerHTML=data.data;
                jQuery.sitebuilder.Log.logMessage('\n===convertHtmlToJs data===\n' + data.convertJs+'\n=================\n', LOG_PRIORITY.DEBUG);
                eval(data.convertJs);
                return this.get(0).innerHTML;
            
            }catch(e){
                return this.get(0).innerHTML = catchData;
            }
        }
        
        jQuery.fn.LoadingDisplay = function(even, opt) {
        	
            if (even == "ajaxSend") {
           	 jQuery(this).showLoading(opt);
            } else {
           	 jQuery(this).hideLoading(opt);
            }
      }
        jQuery.fn.LoadingDisplayComplete = function(even, opt){
 
            if (even == "ajaxSend" ) {
            	jQuery(this).showLoading(opt);
            }else if (even == 'ajaxComplete') {
            	jQuery(this).showLoading(opt);
            } else {
            	jQuery(this).hideLoading(opt);
            
            }
      }
 /**
 * @author tanawat & pornthip
 * @doing  show image loading on dialog box jQuery
 */
        jQuery.fn.showLoading = function(opt)
        {
        	//alert(this.find('#builditemLoadingCenter').get(0))
        	if(!this.find('#builditemLoadingCenter').get(0)) {
        		this.parent().find('.ui-dialog-buttonpane').css({'visibility':'hidden'});
                var confWdith = 100;
                var confHeight = 10;
                
                //ui-dialog-title-
                //alert('#ui-dialog-title-'+this.get(0).id)
                dialogHeight = this.height()+65
                var centerw = (this.width()/2)-(confWdith/2);
                var centerh = (dialogHeight/2)-(confHeight/2);
                var itemLoad = '<table cellspacing="1" cellpadding="0" ><tr><td><img  src="'+PUBLIC_IMG_URL+'loading02.gif" alt="" width="29" height="27" border="0"  /></td><td>'+rvsloading+'</td></tr></table>';
                var div = jQuery('<div/>');

        		if(opt) {
        			centerw = (opt.left) ? opt.left : centerw;
                	centerh = (opt.top) ? opt.top : centerh;
        		}
                  var loadCss = {
                            'position':'absolute'
                            ,'left':centerw+'px'
                            ,'top':centerh+'px'
                            ,'background-color':'#FFFFFF'
                            ,'width':confWdith+'px'
                        };

                div.css(loadCss);
                div.addClass('builditemLoadingCenter');
                div.attr('id','builditemLoadingCenter');
                div.html(itemLoad);
                objLoad = this.append(div);
        	}
        }
 /**
 * @author tanawat & pornthip
 * @doing  hide image loading on dialog box jQuery
 */
        jQuery.fn.hideLoading = function(opt)
        {
        	
              jQuery('.builditemLoadingCenter').remove();
              //  jQuery('#builditemLoadingCenter').remove();
              this.parent().find('.ui-dialog-buttonpane').css({'visibility':'visible'});
              
        }
        jQuery.fn.buildDialogError = function(defXHR,afterClose)
        {
        /**
                 * Default process on event error.
                 * If want over write this function, you can setting callback in settings.doError
                 */
                    try{
                    // try defXHR.error is string
                    //var isdefXHRerror = eval('isdefXHRerror = "'+defXHR['error']+'"');
                    var isdefXHRerror = (jQuery.json.decode(defXHR.error));
                    }catch(e){
                    //  defXHR.error is object
                    var isdefXHRerror = defXHR['error'];
                    }
                if (defXHR.errorType === 'MGR') {
                    var errorTitle = "Error";
                    var errorText = '';
                    if(typeof (isdefXHRerror) === 'object' ) {
                        for(key in isdefXHRerror) {
                        if( typeof (isdefXHRerror[key]) != 'function' )     
                            errorText += isdefXHRerror[key];
                        }
                    } else {
                        errorText += defXHR.error
                  }
                    
                } else {
                    errorTitle = "System";
                    errorText = defXHR.message;    
                }
                    
                ErrDialog = jQuery("<div/>").dialog({
                    modal: true,
                    title: errorTitle,
                    height: 'auto',
                    resizable: 'auto',
                    autoOpen: false,
                    buttons:{
                        "Close": function() { 
                			ErrDialog.dialog('close');
                			if (typeof(afterClose) == 'function') {
                				afterClose();
                			}
                		}
                    }
                });

                aa = jQuery("<div/>").addClass("ui-state-highlight ui-corner-all").appendTo(ErrDialog);
                dd = jQuery("<p/>").appendTo(aa);
                bb = jQuery("<span/>").addClass("ui-icon ui-icon-info").css({'float':'left','margin-right':'0.3em'}).appendTo(dd);
                cc = jQuery("<span/>").attr('id','msg').html(errorText).appendTo(dd);
                ErrDialog.dialog('open');
                return this;
        }
        
         jQuery.fn.buildFrame = function(obj) {

         if ( jQuery(this).find("#"+obj.id).is(":visible")) {
           // alert("remove")
                jQuery(this).find('#'+obj.id).remove()
            }
            oThis = jQuery(this)
            ifhtml = jQuery("<iframe/>").attr(obj).appendTo(oThis)
            setGoto = obj.src ? obj.src:'';
            
             oThis.find("#"+obj.id).attr({"src":""})
         oThis.find("#"+obj.id).attr(obj)
         }
        
        jQuery.fn.displayTagProblemIE67 = function(val){  
         if(jQuery.browser.msie && jQuery.browser.version < 7) {
                                 jQuery(this).css({'visibility':val}); 
                                 }
        }
        jQuery.fn.wordwrap = function(options)
    	{
    	    var settings = {
    	        width: 50,
                cut:true,
                brk: '<br/>\n'
            };
            
            jQuery.extend(settings, options);
                
    		return this.each(function() 
    		{
    		    jQuery(this).html(jQuery.sitebuilder.string.wordwrap(jQuery(this).html(),settings.width,settings.brk,settings.cut));
    		});
    	}


        
        /**
         * Open new window
         */
        jQuery.fn.openWindown = function(url, name, isEnabledirtyForm) {
            var options = {
                url :  url,
                name : (name) ? name : ''
            };
            
            if (isEnabledirtyForm) {
                newWindows()
            } else {
                newWindows()
            }
            
            function newWindows() {
                var isIe = document.all? true: false;
                if (options.name){
                    win = window.open(options.url, options.name);
                }else {
                    win = window.open(options.url);
                }
                window.focus();
                if (isIe = true){
                    win.resizeTo(window.screen.availWidth, window.screen.availHeight);
                    win.moveTo(0, 0);    
                }
                win.focus();
            };
        }
        
        /**
         * Dirty form windown
         */
         jQuery.fn.dirtyFormWin = function() {
            var winName = window.name;
            //  var lostWarning = "You have made any changes to the fields without submitting, your changes will be lost.";
            //  var lostWarning = document.getElementById("dirtyFormMsg").value;

            if (winName == "edtingframe") {

                aDirtyForm = isDirtyFormWYS();
                if (aDirtyForm == true) return  lostWarning;

            } else {
    
                if (document.getElementById("thisStep")) {
                    var thisStep =  document.getElementById("thisStep").value;      //alert("thisStep=" + thisStep);
                } else {
                    var thisStep = 0;       //alert("thisStep=" + thisStep);
                }
            
                if (thisStep != 4 & thisStep !=3 & thisStep !=5 & thisStep !=2) {
                    aDirtyForm = isDirtyForm();
                    if(aDirtyForm == true) return  lostWarning;
                }else if (thisStep == 4) {               
                    aDirtyForm = isDirtyFormPageStructure();
                    if (aDirtyForm == true) return  lostWarning;
                } else if (thisStep == 3) {               
                    aDirtyForm = isDirtyForm();
                    aDirtyFormHidden =  isDirtyHiddenField();
               
                    if (aDirtyForm == true ) return lostWarning;         
                    if (aDirtyFormHidden == true ) return  lostWarning;  
                }           
            
            }
        }
         
        /*
         * make Show subMenu by Div
         * oTarget = '#idDivShowSubmenu'
         * evt = 'show','hide'
         * add by darawan 26/02/53
         * */
       jQuery.fn.subMenu = function(oTarget,staDis){
    	   	if(staDis == 'show'){
    	   		a = jQuery(this);
    	   		ap = a.position();
    	   		jQuery(oTarget).css({
    	   			left:ap.left+a.width(),
					top:ap.top
				}).each(function(){
					//jQuery.sitebuilder.Log.logMessage('fn subMenu : frmid='+jQuery(oTarget).attr('frmID'), LOG_PRIORITY.DEBUG);
					jQuery(oTarget).show();			
				});
			} else if (staDis == 'hide'){
				jQuery(this).bind('mouseleave',function(){
					//jQuery.sitebuilder.Log.logMessage(' jQuery.fn.subMenu : staDis='+staDis, LOG_PRIORITY.DEBUG);
					jQuery(oTarget).hide();
				});	
			}
    	   	return this;
        }
        
    })(jQuery);
}

function print_js(obj){

    var de = '';
        for(key in obj) {
            de+=key+'\n'
        }
    return de;
}


/*!
 * Galleria v 1.1.95 2010-08-06
 * http://galleria.aino.se
 *
 * Copyright (c) 2010, Aino
 * Licensed under the MIT license.
 */
var rvActiveFulls = 'normal';
(function() {

var initializing = false,
    fnTest = /xyz/.test(function(){xyz;}) ? /\b__super\b/ : /.*/,
    Class = function(){},
    window = this;

Class.extend = function(prop) {
    var __super = this.prototype;
    initializing = true;
    var proto = new this();
    initializing = false;
    for (var name in prop) {
        if (name) {
            proto[name] = typeof prop[name] == "function" && 
                typeof __super[name] == "function" && fnTest.test(prop[name]) ? 
                (function(name, fn) { 
                    return function() { 
                        var tmp = this.__super; 
                        this.__super = __super[name]; 
                        var ret = fn.apply(this, arguments);
                        this.__super = tmp; 
                        return ret; 
                    }; 
                })(name, prop[name]) : prop[name]; 
        } 
    }

    function Class() {
        if ( !initializing && this.__constructor ) {
            this.__constructor.apply(this, arguments);
        }
    }
    Class.prototype = proto;
    Class.constructor = Class;
    Class.extend = arguments.callee;
    return Class;
};

var Base = Class.extend({
    loop : function( elem, fn) {
        var scope = this;
        if (typeof elem == 'number') {
            elem = new Array(elem);
        }
        jQuery.each(elem, function() {
            fn.call(scope, arguments[1], arguments[0]);
        });
        return elem;
    },
    create : function( elem, className ) {
        elem = elem || 'div';
        var el = document.createElement(elem);
        if (className) {
            el.className = className;
        }
        return el;
    },
    getElements : function( selector ) {
        var elems = {};
        this.loop( jQuery(selector), this.proxy(function( elem ) {
            this.push(elem, elems);
        }));
        return elems;
    },
    setStyle : function( elem, css ) {
        jQuery(elem).css(css);
        return this;
    },
    setTitle : function( elem, title ) {
        jQuery(elem).attr('title',title);
        return this;
    },
    getStyle : function( elem, styleProp, parse ) {
        var val = jQuery(elem).css(styleProp);
        return parse ? this.parseValue( val ) : val;
    },
    cssText : function( string ) {
        var style = document.createElement('style');
        this.getElements('head')[0].appendChild(style);
        if (style.styleSheet) { // IE
            style.styleSheet.cssText = string;
        } else {
            var cssText = document.createTextNode(string);
            style.appendChild(cssText);
        }
        return this;
    },
    touch : function(el) {
        var sibling = el.nextSibling;
        var parent = el.parentNode;
        parent.removeChild(el);
        if ( sibling ) {
            parent.insertBefore(el, sibling);
        } else {
            parent.appendChild(el);
        }
        if (el.styleSheet && el.styleSheet.imports.length) {
            this.loop(el.styleSheet.imports, function(i) {
                el.styleSheet.addImport(i.href);
            });
        }
    },
    loadCSS : function(href, callback) {
        var exists = this.getElements('link[href="'+href+'"]').length;
        if (exists) {
            callback.call(null);
            return exists[0];
        }
        var link = this.create('link');
        link.rel = 'stylesheet';
        link.href = href;
        
        if (typeof callback == 'function') {
            // a new css check method, still experimental...
            this.wait(function() {
                return !!document.body;
            }, function() {
                var testElem = this.create('div', 'galleria-container galleria-stage');
                this.moveOut(testElem);
                document.body.appendChild(testElem);
                var getStyles = this.proxy(function() {
                    var str = '';
                    var props;
                    if (document.defaultView && document.defaultView.getComputedStyle) {
                        props = document.defaultView.getComputedStyle(testElem, "");
                        this.loop(props, function(prop) {
                            str += prop + props.getPropertyValue(prop);
                        });
                    } else if (testElem.currentStyle) { // IE
                        props = testElem.currentStyle;
                        this.loop(props, function(val, prop) {
                            str += prop + val;
                        });
                    }
                    return str;
                });
                var current = getStyles();
                this.wait(function() {
                    return getStyles() !== current;
                }, function() {
                    document.body.removeChild(testElem);
                    callback.call(link);
                }, function() {
                    //G.raise('Could not confirm theme CSS');
                }, 2000);
            });
        }
        window.setTimeout(this.proxy(function() {
            var styles = this.getElements('link[rel="stylesheet"],style');
            if (styles.length) {
                styles[0].parentNode.insertBefore(link, styles[0]);
            } else {
                this.getElements('head')[0].appendChild(link);
            }
            // IE needs a manual touch to re-order the cascade
            if (G.IE) {
                this.loop(styles, function(el) {
                    this.touch(el);
                })
            }
        }), 2);
        return link;
    },
    moveOut : function( elem ) {
        return this.setStyle(elem, {
            position: 'absolute',
            left: '-10000px',
            display: 'block'
        });
    },
    moveIn : function( elem ) {
        return this.setStyle(elem, {
            left: '0'
        }); 
    },
    reveal : function( elem ) {
        return jQuery( elem ).show();
    },
    hide : function( elem ) {
        return jQuery( elem ).hide();
    },
    mix : function() {
        return jQuery.extend.apply(jQuery, arguments);
    },
    proxy : function( fn, scope ) {
        if ( typeof fn !== 'function' ) {
            return function() {};
        }
        scope = scope || this;
        return function() {
            return fn.apply( scope, Array.prototype.slice.call(arguments) );
        };
    },
    listen : function( elem, type, fn ) {
        jQuery(elem).bind( type, fn );
    },
    forget : function( elem, type, fn ) {
        jQuery(elem).unbind(type, fn);
    },
    dispatch : function( elem, type ) {
        jQuery(elem).trigger(type);
    },
    clone : function( elem, keepEvents ) {
        keepEvents = keepEvents || false;
        return jQuery(elem).clone(keepEvents)[0];
    },
    removeAttr : function( elem, attributes ) {
        this.loop( attributes.split(' '), function(attr) {
            jQuery(elem).removeAttr(attr);
        });
    },
    push : function( elem, obj ) {
        if (typeof obj.length == 'undefined') {
            obj.length = 0;
        }
        Array.prototype.push.call( obj, elem );
        return elem;
    },
    width : function( elem, outer ) {
        return this.meassure(elem, outer, 'Width');
    },
    height : function( elem, outer ) {
        return this.meassure(elem, outer, 'Height');
    },
    meassure : function(el, outer, meassure) {
        var elem = jQuery( el );
        var ret = outer ? elem['outer'+meassure](true) : elem[meassure.toLowerCase()]();
        // fix quirks mode
        if (G.QUIRK) {
            var which = meassure == "Width" ? [ "left", "right" ] : [ "top", "bottom" ];
            this.loop(which, function(s) {
                ret += elem.css('border-' + s + '-width').replace(/[^\d]/g,'') * 1;
                ret += elem.css('padding-' + s).replace(/[^\d]/g,'') * 1;
            });
        }
        return ret;
    },
    toggleClass : function( elem, className, arg ) {
        if (typeof arg !== 'undefined') {
            var fn = arg ? 'addClass' : 'removeClass';
            jQuery(elem)[fn](className);
            return this;
        }
        jQuery(elem).toggleClass(className);
        return this;
    },
    hideAll : function( el ) {
        jQuery(el).find('*').hide();
    },
    animate : function( el, options ) {
        options.complete = this.proxy(options.complete);
        var elem = jQuery(el);
        if (!elem.length) {
            return;
        }
        if (options.from) {
            elem.css(from);
        }
        elem.animate(options.to, {
            duration: options.duration || 400,
            complete: options.complete,
            easing: options.easing || 'swing'
        });
    },
    wait : function(fn, callback, err, max) {
        fn = this.proxy(fn);
        callback = this.proxy(callback);
        err = this.proxy(err);
        var ts = new Date().getTime() + (max || 3000);
        window.setTimeout(function() {
            if (fn()) {
                callback();
                return false;
            }
            if (new Date().getTime() >= ts) {
                err();
                callback();
                return false;
            }
            window.setTimeout(arguments.callee, 2);
        }, 2);
        return this;
    },
    loadScript: function(url, callback) {
       var script = document.createElement('script');
       script.src = url;
       script.async = true; // HTML5

       var done = false;
       var scope = this;

       // Attach handlers for all browsers
       script.onload = script.onreadystatechange = function() {
           if ( !done && (!this.readyState ||
               this.readyState == "loaded" || this.readyState == "complete") ) {
               done = true;
               
               if (typeof callback == 'function') {
                   callback.call(scope, this);
               }

               // Handle memory leak in IE
               script.onload = script.onreadystatechange = null;
           }
       };
       var s = document.getElementsByTagName('script')[0];
       s.parentNode.insertBefore(script, s);
       
       return this;
    },
    parseValue: function(val) {
        if (typeof val == 'number') {
            return val;
        } else if (typeof val == 'string') {
            var arr = val.match(/\-?\d/g);
            return arr && arr.constructor == Array ? arr.join('')*1 : 0;
        } else {
            return 0;
        }
    }
});

var Picture = Base.extend({
    __constructor : function(order) {
	
        this.image = null;
        this.elem = this.create('div', 'galleria-image');
        this.isDesc = false;
        this.setStyle( this.elem, {
            overflow: 'hidden',
            position: 'relative' // for IE Standards mode
        } );
        this.order = order;
        this.orig = { w:0, h:0, r:1 };
    },
    
    cache: {},
    ready: false,
    
    add: function(src) {
        if (this.cache[src]) {
            return this.cache[src];
        }
        var image = new Image();
        image.src = src;
        this.setStyle(image, {display: 'block'});
        if (image.complete && image.width) {
            this.cache[src] = image;
            return image;
        }
        image.onload = (function(scope) {
            return function() {
                scope.cache[src] = image;
            };
        })(this);
        return image;
    },
    
    isCached: function(src) {
        return this.cache[src] ? this.cache[src].complete : false;
    },
    
    make: function(src) {
        var i = this.cache[src] || this.add(src);
        return this.clone(i);
    },
    
    load: function(src, callback) {
    	
        callback = this.proxy( callback );
        this.elem.innerHTML = '';      
        this.image = this.make( src );    
        this.moveOut( this.image );
        this.elem.appendChild( this.image );
       
        this.wait(function() {
            return (this.image.complete && this.image.width);
        }, function() {
            this.orig = {
                h: this.h || this.image.height,
                w: this.w || this.image.width
            };
            callback( {target: this.image, scope: this} );
        }, function() {
           // G.raise('image not loaded in 20 seconds: '+ src);
        }, 20000);
        return this;
    },
    
    scale: function(options) {
        var o = this.mix({
            width: 0,
            height: 0,
            min: undefined,
            max: undefined,
            margin: 0,
            complete: function(){},
            position: 'center',
            crop: false,
            viewOrg: false /// opt view image original
        }, options);
        if (!this.image) {
            return this;
        }
        var width,height;
        this.wait(function() {
            width  = o.width || this.width(this.elem);
            height = o.height || this.height(this.elem);
            return width && height;
        }, function() {
            var nw = (width - o.margin*2) / this.orig.w;
            var nh = (height- o.margin*2) / this.orig.h;
            var rmap = {
                'true': Math.max(nw,nh),
                'width': nw,
                'height': nh,
                'false': Math.min(nw,nh)
            }
            var ratio = rmap[o.crop.toString()];
            if (o.max) {
                ratio = Math.min(o.max, ratio);
            }
            if (o.min) {
                ratio = Math.max(o.min, ratio);
            }
            this.setStyle(this.elem, {
                width: width,
                height: height
            });
            /// start config view image Original
            /**************************************
             * case ภาพแนวนอน, ภาพแนวตั้ง
             * ภาพแนวนอน : 	ถ้าแนวกว้าง นอ้ยกว่า div : ก็เอา กว้าง มาได้เลย
             * 							ถ้าแนวกว้าง มากกว่า div : ก็เอากว้างของ div มาใช้ แล้วคำนวณ สูง ใหม่ให้สมดุลกัน
             * ภาพแนวตั้ง : ถ้าแนวสูง นอ้ยกว่า div : ก็เอา สูง มาได้เลย
             * 						ถ้าแนวสูง มากกว่า div : ก็เอาสูงของ div มาใช้ แล้วคำนวน กว้าง ใหม่ ให้สมดุลกัน
             **************************************/
            if(o.viewOrg == true) {
            	divW = Math.ceil(this.orig.w * ratio); /// W =  div image
            	divH = Math.ceil(this.orig.h * ratio); /// H =  div image
            	if(this.orig.w >= this.orig.h ) { /// ภาพแนวนอน
            		if(this.orig.h < height) { 
            			this.image.width = (this.orig.w < width) ? this.orig.w : divW;
            			this.image.height = (this.image.width * this.orig.h)/this.orig.w;
            		} else {
            			this.image.height = divH;
            			this.image.width = (this.image.height * this.orig.w)/this.orig.h;
            		}
            	} else { /// ภาพแนวตั้ง
            		if(this.orig.w < width) {
            			this.image.height = (this.orig.h < height) ? this.orig.h : divH;
            			this.image.width = (this.image.height * this.orig.w)/this.orig.h;
            		} else {
            			this.image.width = divW;
            			this.image.height = (this.image.width * this.orig.h)/this.orig.w;
            		}
            	}
            } else {
            	this.image.width = Math.ceil(this.orig.w * ratio);
            	this.image.height = Math.ceil(this.orig.h * ratio);
            }
             /// end config view image Original
            var getPosition = this.proxy(function(value, img, m) {
                var result = 0;
                if (/\%/.test(value)) {
                    var pos = parseInt(value) / 100;
                    result = Math.ceil(this.image[img] * -1 * pos + m * pos);
                } else {
                    result = parseInt(value);
                }
                return result;
            });
            
            var map = {
                'top': { top: 0 },
                'left': { left: 0 },
                'right': { left: '100%' },
                'bottom': { top: '100%' }
            }
            
            var pos = {};
            var mix = {};
            
            this.loop(o.position.toLowerCase().split(' '), function(p, i) {
                if (p == 'center') {
                    p = '50%';
                }
                pos[i ? 'top' : 'left'] = p;
            });

            this.loop(pos, function(val, key) {
                if (map.hasOwnProperty(val)) {
                    mix = this.mix(mix, map[val]);
                }
            });
            
            pos = pos.top ? this.mix(pos, mix) : mix;
            
            pos = this.mix({
                top: '50%',
                left: '50%'
            }, pos);

            this.setStyle(this.image, {
                position : 'relative',
                top :  getPosition(pos.top, 'height', height),
                left : getPosition(pos.left, 'width', width)
            });
            this.ready = true;
            o.complete.call(this);
        });
        return this;
    }  
});

var G = window.Galleria = Base.extend({
    
    __constructor : function(options) {
        this.theme = undefined;
        this.options = options;
        this.playing = false;
        this.playtime = 5000;
        this.active = null;
        this.queue = {};
        this.data = {};
        this.dom = {};
        
        var kb = this.keyboard = {
            keys : {
                UP: 38,
                DOWN: 40,
                LEFT: 37,
                RIGHT: 39,
                RETURN: 13,
                ESCAPE: 27,
                BACKSPACE: 8
            },
            map : {},
            bound: false,
            press: this.proxy(function(e) {
                var key = e.keyCode || e.which;
                if (kb.map[key] && typeof kb.map[key] == 'function') {
                    kb.map[key].call(this, e);
                }
            }),
            attach: this.proxy(function(map) {
                for( var i in map ) {
                    var k = i.toUpperCase();
                    if ( kb.keys[k] ) {
                        kb.map[kb.keys[k]] = map[i];
                    }
                }
                if (!kb.bound) {
                    kb.bound = true;
                    this.listen(document, 'keydown', kb.press);
                }
            }),
            detach: this.proxy(function() {
                kb.bound = false;
                this.forget(document, 'keydown', kb.press);
            })
        };
        
        this.timeouts = {
            trunk: {},
            add: function(id, fn, delay, loop) {
                loop = loop || false;
                this.clear(id);
                if (loop) {
                    var self = this;
                    var old = fn;
                    fn = function() {
                        old();
                        self.add(id,fn,delay);
                    }
                }
                this.trunk[id] = window.setTimeout(fn,delay);
            },
            clear: function(id) {
                if (id && this.trunk[id]) {
                    window.clearTimeout(this.trunk[id]);
                    delete this.trunk[id];
                } else if (typeof id == 'undefined') {
                    for (var i in this.trunk) {
                        window.clearTimeout(this.trunk[i]);
                        delete this.trunk[i];
                    }
                }
            }
        };
        
        this.controls = {
            0 : null,
            1 : null,
            active : 0,
            swap : function() {
                this.active = this.active ? 0 : 1;
            },
            getActive : function() {
                return this[this.active];
            },
            getNext : function() {
                return this[Math.abs(this.active - 1)];
            }
        };
        
        var fs = this.fullscreen = {
        				ie7Height:0,
            scrolled: 0,
            enter: this.proxy(function() {
            	if(G.IE7) {
            		fs.ie7Height = this.get('container').style.height;
                			}
                this.toggleClass( this.get('container'), 'fullscreen');
                fs.scrolled = jQuery(window).scrollTop();
                this.loop(fs.getElements(), function(el, i) {
                    fs.styles[i] = el.getAttribute('style');
                    el.removeAttribute('style');
                });
                this.setStyle(fs.getElements(0), {
                    position: 'fixed',
                    top: 0,
                    left: 0,
                    width: '100%',
                    height: '100%',
                    zIndex: 10000
                });
                var bh = {
                    height: '100%',
                    overflow: 'hidden',
                    margin:0,
                    padding:0
                };
                this.setStyle( fs.getElements(1), bh );
                this.setStyle( fs.getElements(2), bh );
                this.attachKeyboard({
                    escape: this.exitFullscreen,
                    right: this.next,
                    left: this.prev
                });
                this.rescale(this.proxy(function() {
                    this.trigger(G.FULLSCREEN_ENTER);
                }));
                this.listen(window, 'resize', fs.scale);
            }),
            scale: this.proxy(function() {
                this.rescale();
            }),
            exit: this.proxy(function() {
                this.toggleClass( this.get('container'), 'fullscreen', false);
                if (!fs.styles.length) {
                    return;
                }
                this.loop(fs.getElements(), function(el, i) {
                    el.removeAttribute('style');
                    el.setAttribute('style', fs.styles[i]);
                });
                window.scrollTo(0, fs.scrolled);
                this.detachKeyboard();
                this.rescale(this.proxy(function() {
                    this.trigger(G.FULLSCREEN_EXIT);
                }));
                this.forget(window, 'resize', fs.scale);
              if(G.IE7) {
                this.get('container').style.height =fs.ie7Height;
                			}
            }),
            styles: [],
            getElements: this.proxy(function(i) {
                var elems = [ this.get('container'), document.body, this.getElements('html')[0] ];
                return i ? elems[i] : elems;
            })
        };
        
        var idle = this.idle = {
            trunk: [],
            bound: false,
            add: this.proxy(function(elem, styles, fn) {
                if (!elem) {
                    return;
                }
                if (!idle.bound) {
                    idle.addEvent();
                }
                elem = jQuery(elem);
                var orig = {};
                for (var style in styles) {
                    orig[style] = elem.css(style);
                }
                elem.data('idle', {
                    from: orig,
                    to: styles,
                    complete: true,
                    busy: false,
                    fn: this.proxy(fn)
                });
                idle.addTimer();
                idle.trunk.push(elem);
            }),
            remove: this.proxy(function(elem) {
                elem = jQuery(elem);
                this.loop(idle.trunk, function(el, i) {
                    if ( el && !el.not(elem).length ) {
                        idle.show(elem);
                        idle.trunk.splice(i,1);
                    }
                });
                if (!idle.trunk.length) {
                    idle.removeEvent();
                    this.clearTimer('idle');
                }
            }),
            addEvent: this.proxy(function() {
                idle.bound = true;
                this.listen( this.get('container'), 'mousemove click', idle.showAll );
            }),
            removeEvent: this.proxy(function() {
                idle.bound = false;
                this.forget( this.get('container'), 'mousemove click', idle.showAll );
            }),
            addTimer: this.proxy(function() {
                this.addTimer('idle', this.proxy(function() {
                    idle.hide();
                }),this.options.idle_time);
            }),
            hide: this.proxy(function() {
                this.trigger(G.IDLE_ENTER);
                this.loop(idle.trunk, function(elem) {
                    var data = elem.data('idle');
                    data.complete = false;
                    data.fn();
                    elem.animate(data.to, {
                        duration: 600,
                        queue: false,
                        easing: 'swing'
                    });
                });
            }),
            showAll: this.proxy(function() {
                this.clearTimer('idle');
                this.loop(idle.trunk, function(elem) {
                    idle.show(elem);
                });
            }),
            show: this.proxy(function(elem) {
                var data = elem.data('idle');
                if (!data.busy && !data.complete) {
                    data.busy = true;
                    this.trigger(G.IDLE_EXIT);
                    elem.animate(data.from, {
                        duration: 300,
                        queue: false,
                        easing: 'swing',
                        complete: function() {
                            $(this).data('idle').busy = false;
                            $(this).data('idle').complete = true;
                        }
                    });
                }
                idle.addTimer();
            })
        };
        
        var lightbox = this.lightbox = {
            w: 0,
            h: 0,
            initialized: false,
            active: null,
            init: this.proxy(function() {
                if (lightbox.initialized) {
                    return;
                }
                lightbox.initialized = true;
                var elems = 'lightbox-overlay lightbox-box lightbox-content lightbox-shadow lightbox-title ' +
                            'lightbox-info lightbox-close lightbox-prev lightbox-next lightbox-counter';
                this.loop(elems.split(' '), function(el) {
                    this.addElement(el);
                    lightbox[el.split('-')[1]] = this.get(el);
                });
                
                lightbox.image = new Galleria.Picture();
                
                this.append({
                    'lightbox-box': ['lightbox-shadow','lightbox-content', 'lightbox-close'],
                    'lightbox-info': ['lightbox-title','lightbox-counter','lightbox-next','lightbox-prev'],
                    'lightbox-content': ['lightbox-info']
                });
                document.body.appendChild( lightbox.overlay );
                document.body.appendChild( lightbox.box );
                lightbox.content.appendChild( lightbox.image.elem );
                
                lightbox.close.innerHTML = '&#215;';
                lightbox.prev.innerHTML = '&#9668;';
                lightbox.next.innerHTML = '&#9658;';
                
                this.listen( lightbox.close, 'click', lightbox.hide );
                this.listen( lightbox.overlay, 'click', lightbox.hide );
                this.listen( lightbox.next, 'click', lightbox.showNext );
                this.listen( lightbox.prev, 'click', lightbox.showPrev );
                
                if (this.options.lightbox_clicknext) {
                    this.setStyle( lightbox.image.elem, {cursor:'pointer'} );
                    this.listen( lightbox.image.elem, 'click', lightbox.showNext);
                }
                this.setStyle( lightbox.overlay, {
                    position: 'fixed', display: 'none',
                    opacity: this.options.overlay_opacity,
                    top: 0, left: 0, width: '100%', height: '100%',
                    background: this.options.overlay_background, zIndex: 99990
                });
                this.setStyle( lightbox.box, {
                    position: 'fixed', display: 'none',
                    width: 400, height: 400, top: '50%', left: '50%',
                    marginTop: -200, marginLeft: -200, zIndex: 99991
                });
                this.setStyle( lightbox.shadow, {
                    background:'#000', opacity:.4, width: '100%', height: '100%', position: 'absolute'
                });
                this.setStyle( lightbox.content, {
                    backgroundColor:'#fff',position: 'absolute',
                    top: 10, left: 10, right: 10, bottom: 10, overflow: 'hidden'
                });
                this.setStyle( lightbox.info, {
                    color: '#444', fontSize: '11px', fontFamily: 'arial,sans-serif', height: 13, lineHeight: '13px',
                    position: 'absolute', bottom: 10, left: 10, right: 10, opacity: 0
                });
                this.setStyle( lightbox.close, {
                    background: '#fff', height: 20, width: 20, position: 'absolute', textAlign: 'center', cursor: 'pointer',
                    top: 10, right: 10, lineHeight: '22px', fontSize: '16px', fontFamily:'arial,sans-serif',color:'#444', zIndex: 99999
                });
                this.setStyle( lightbox.image.elem, {
                    top: 10, left: 10, right: 10, bottom: 30, position: 'absolute'
                });
                this.loop('title prev next counter'.split(' '), function(el) {
                    var css = { display: 'inline', 'float':'left' };
                    if (el != 'title') {
                        this.mix(css, { 'float': 'right'});
                        if (el != 'counter') {
                            this.mix(css, { cursor: 'pointer'});
                        } else {
                            this.mix(css, { marginLeft: 8 });
                        }
                    }
                    this.setStyle(lightbox[el], css);
                });
                this.loop('prev next close'.split(' '), function(el) {
                    this.listen(lightbox[el], 'mouseover', this.proxy(function() {
                        this.setStyle(lightbox[el], { color:'#000' });
                    }));
                    this.listen(lightbox[el], 'mouseout', this.proxy(function() {
                        this.setStyle(lightbox[el], { color:'#444' });
                    }));
                });
                this.trigger(G.LIGHTBOX_OPEN);
            }),
            rescale: this.proxy(function(e) {
                var w = Math.min( this.width(window), lightbox.w );
                var h = Math.min( this.height(window), lightbox.h );
                var r = Math.min( (w-60) / lightbox.w, (h-80) / lightbox.h );
                var destW = (lightbox.w * r) + 40;
                var destH = (lightbox.h * r) + 60;
                var dest = {
                    width: destW,
                    height: destH,
                    marginTop: Math.ceil(destH/2)*-1,
                    marginLeft: Math.ceil(destW)/2*-1
                }
                if (!e) {
                    this.animate( lightbox.box, {
                        to: dest,
                        duration: this.options.lightbox_transition_speed,
                        easing: 'galleria',
                        complete: function() {
                            this.trigger({
                                type: G.LIGHTBOX_IMAGE,
                                imageTarget: lightbox.image.image
                            });
                            this.moveIn( lightbox.image.image );
                            this.animate( lightbox.image.image, { to: { opacity:1 }, duration: this.options.lightbox_fade_speed } );
                            this.animate( lightbox.info, { to: { opacity:1 }, duration: this.options.lightbox_fade_speed } );
                        }
                    });
                } else {
                    this.setStyle( lightbox.box, dest );
                }
            }),
            hide: this.proxy(function() {
                lightbox.image.image = null;
                this.forget(window, 'resize', lightbox.rescale);
                this.hide( lightbox.box );
                this.setStyle( lightbox.info, { opacity: 0 } );
                this.animate( lightbox.overlay, {
                    to: { opacity: 0 },
                    duration: 200,
                    complete: function() {
                        this.hide( lightbox.overlay );
                        this.setStyle( lightbox.overlay, { opacity: this.options.overlay_opacity});
                        this.trigger(G.LIGHTBOX_CLOSE);
                    }
                });
            }),
            showNext: this.proxy(function() {
                lightbox.show(this.getNext(lightbox.active));
            }),
            showPrev: this.proxy(function() {
                lightbox.show(this.getPrev(lightbox.active));
            }),
            show: this.proxy(function(index) {
                if (!lightbox.initialized) {
                    lightbox.init();
                }
                this.forget( window, 'resize', lightbox.rescale );
                index = typeof index == 'number' ? index : this.getIndex();
                lightbox.active = index;
                
                var data = this.getData(index);
                var total = this.data.length;
                this.setStyle( lightbox.info, {opacity:0} );

                lightbox.image.load( data.image, function(o) {
                    lightbox.w = o.scope.orig.w;
                    lightbox.h = o.scope.orig.h;
                    this.setStyle(o.target, {
                        width: '100.5%',
                        height: '100.5%',
                        top:0,
                        zIndex: 99998,
                        opacity: 0
                    });
                    lightbox.title.innerHTML = data.title;
                    lightbox.counter.innerHTML = (index+1) + ' / ' + total;
                    this.listen( window, 'resize', lightbox.rescale );
                    lightbox.rescale();
                });
                this.reveal( lightbox.overlay );
                this.reveal( lightbox.box );
            })
        };
        
        this.thumbnails = { width: 0 };
        this.thumbnailsAlbum = { width: 0 };
        this.stageWidth = 0;
        this.stageHeight = 0;
        
        var elems = 'container stage images image-nav image-nav-left image-nav-right ' + 
                    'info info-text info-title info-description info-author ' +
                    'thumbnails thumbnails-list thumbnails-container thumb-nav-left thumb-nav-right ' +
                    'loader counter';
        elems = elems.split(' ');
        
        this.loop(elems, function(blueprint) {
            this.dom[ blueprint ] = this.create('div', 'galleria-' + blueprint);
        });
        
        this.target = this.dom.target = options.target.nodeName ? 
            options.target : this.getElements(options.target)[0];

        if (!this.target) {
             G.raise('Target not found.');
        }
    },
    
    init: function() {
        
        this.options = this.mix(G.theme.defaults, this.options);
        this.options = this.mix({
        	stage_ctrl : 'image',
        	stage_fullscreen : 'full',
        	callrun : 'run',
            autoplay: false,
            carousel: true,
            carousel_follow: true,
            carousel_speed: 400,
            carousel_steps: 'auto',
            carousel_album: true,
            carousel_follow_album: true,
            carousel_speed_album: 400,
            carousel_steps_album: 'auto',
            clicknext: false,
            data_config : function( elem ) { return {}; },
            data_image_selector: 'img',
            data_source: this.target,
            folder_source :{},
			gallery_source : {},
			rvsDelay : ['2000','3000','5000','7000'],
			rvsEffect :['flash','fade','pulse','slide'],
			currentDatas:{},
			dataEmpty:false,
            data_type: 'auto',
            debug: false,
            extend: function(options) {},
            height: 'auto',
            idle_time: 3000,
            image_crop: false,
            image_original:false, /// conf view image original
			ctrl_autoplay: true,
			conf_fb: true,
			conf_tw: true,
			conf_sp: true,
			conf_mail: true,
            image_margin: 0,
            image_pan: false,
            image_pan_smoothness: 12,
            image_position: '50%',
            keep_source: false,
            lightbox_clicknext: true,
            lightbox_fade_speed: 200,
            lightbox_transition_speed: 300,
            link_source_images: true,
            max_scale_ratio: undefined,
            min_scale_ratio: undefined,
            on_image: function(img,thumb) {},
            overlay_opacity: .85,
            overlay_background: '#0b0b0b',
            popup_links: false,
            preload: 2,
            queue: true,
            show: 0,
            show_info: true,
            show_counter: true,
            show_imagenav: true,
            thumb_crop: true,
            thumb_fit: true,
            thumb_margin: 0,
            thumb_quality: 'auto',
            thumbnails: true,
            transition: G.transitions.fade,
            transition_speed: 400
        }, this.options);
        
        var o = this.options;
        
        this.bind(G.DATA, function() {
			// / START:: Custom display sitebuilder ::
        	if(this.options.resend) {
        						oTwo = this
        				jQuery('.galleria-thumbnails').html('')
        				jQuery('.galleria-album-stage-image').html('')
        		setTimeout(function(){
        					gallery.thumbnails = [];
        					gallery.options.data_source = oTwo.options.data_source;
        					gallery.options.folder_source = oTwo.options.folder_source;
        					gallery.options.currentDatas = oTwo.options.currentDatas;
        					gallery.options.ctrl_autoplay= aConf.autoPlay;
        					gallery.data = oTwo.options.data_source;     
        					$('.total').html(gallery.data.length);
        					gallery.runFolder();
        				},150);
        	}else {
						if (this.options.callrun == 'rvsrun') {
							this.rvsrun();
			
						}
						opsitionImage = aConf.sizeThumb;
						this.run();
						buildSliderZoom();
        	}
			// / END::
        });
        
        if (o.clicknext) {
            this.loop(this.data, function(data) {
                delete data.link;
            });
            this.setStyle(this.get('stage'), { cursor: 'pointer'} );
            this.listen(this.get('stage'), 'click', this.proxy(function() {
                this.next();
            }));
        }
        
        this.bind(G.IMAGE, function(e) {
            o.on_image.call(this, e.imageTarget, e.thumbTarget);
        });
        
        this.bind(G.READY, function() {
            if (G.History) {
                G.History.change(this.proxy(function(e) {
                    var val = parseInt(e.value.replace(/\//,''));
                    if (isNaN(val)) {
                        window.history.go(-1);
                    } else {
                        this.show(val, undefined, true);
                    }
                }));
            }

            G.theme.init.call(this, o);
            o.extend.call(this, o);
            
            if (/^[0-9]{1,4}$/.test(hash) && G.History) {
                this.show(hash, undefined, true);
            } else if (typeof o.show == 'number') {
                this.show(o.show);
            }
            
            if (o.autoplay) {
                if (typeof o.autoplay == 'number') {
                    this.playtime = o.autoplay;
                }
                this.trigger( G.PLAY );
                this.playing = true;
            }
        });
        this.galleryLoad();
        this.load();
        return this;
    },
    
    bind : function(type, fn) {
        this.listen( this.get('container'), type, this.proxy(fn) );
        return this;
    },
    
    unbind : function(type) {
        this.forget( this.get('container'), type );
    },
    
    trigger : function( type ) {
        type = typeof type == 'object' ? 
            this.mix( type, { scope: this } ) : 
            { type: type, scope: this };
        this.dispatch( this.get('container'), type );
        return this;
    },
    
    addIdleState: function() {
        this.idle.add.apply(this, arguments);
        return this;
    },
    
    removeIdleState: function() {
        this.idle.remove.apply(this, arguments);
        return this;
    },
    
    enterIdleMode: function() {
        this.idle.hide();
        return this;
    },
    
    exitIdleMode: function() {
        this.idle.show();
        return this;
    },
    
    addTimer: function() {
        this.timeouts.add.apply(this.timeouts, arguments);
        return this;
    },
    
    clearTimer: function() {
        this.timeouts.clear.apply(this.timeouts, arguments);
        return this;
    },
    
    enterFullscreen: function() {
        this.fullscreen.enter.apply(this, arguments);
        return this;
    },
    
    exitFullscreen: function() {
        this.fullscreen.exit.apply(this, arguments);
        return this;
    },
    
    openLightbox: function() {
        this.lightbox.show.apply(this, arguments);
    },
    
    closeLightbox: function() {
        this.lightbox.hide.apply(this, arguments);
    },
    
    getActive: function() {
        return this.controls.getActive();
    },
    
    getActiveImage: function() {
        return this.getActive().image || null;
    },
    
    run : function() {
        var o = this.options;
        if (!this.data.length) {
           // G.raise('Data is empty.');
        }
        if (!o.keep_source && !Galleria.IE) {
            this.target.innerHTML = '';
        }
        this.loop(2, function() {
            var image = new Picture();
            image.isDesc =true;
            this.setStyle( image.elem, {
                position: 'absolute',
                top: 0,
                left: 0

            });
            this.setStyle(this.get( 'images' ), {
                position: 'relative',
                top: 0,
                left: 0,
                width: '100%',
                height: '100%'
            });
            
            this.get( 'images' ).appendChild( image.elem );
            this.push(image, this.controls);
        }, this);
        
        if (o.carousel) {
            // try the carousel on each thumb load
            this.bind(G.THUMBNAIL, this.parseCarousel);
        }
        this.bind(G.THUMBNAILALBUM, this.parseCarouselAlbum);
        this.build();
        this.target.appendChild(this.get('container'));
        
        this.loop(['info','counter','image-nav'], function(el) {
            if ( o[ 'show_'+el.replace(/-/,'') ] === false ) {
                this.moveOut( this.get(el) );
            }
        });
        
        var w = 0;
        var h = 0;
        /// start fn rvsrun
        gallery = this;
		var activateShowList = this.proxy(function(e) {
			 this.options.stage_ctrl = 'album';
	         if(aConf.autoPlay == true) gallery.pause();
			 this.showstage();
		});
		this.listen('.btn-next-level', 'click', activateShowList);/// image back to album
		/// image back to top album
		this.listen('.btn-top-level', 'click',function(){
			loadGalleria('',true);
			o.stage_ctrl ='album';
			gallery.showstage();
		});
		this.listen('.btn-fullscreen', 'click', function(){			
			if(o.stage_fullscreen == 'normal') {
				gallery.exitFullscreen();	
				o.stage_fullscreen = 'full'
					rvActiveFulls = 'normal';
			} else {
				gallery.enterFullscreen();
				o.stage_fullscreen = 'normal'
				rvActiveFulls = 'full';
			}
		});
		//effect
		this.listen('.selectEffect', 'change', function(){
			  gallery.options.transition = jQuery(this).val();
		});
		this.listen('.selectDelay', 'change', function(){
			gallery.pause();
		});
		this.listen('.btnPlay', 'click', function(){
			 gallery.play($('.selectDelay').val())
		});
		this.listen('.btnStop', 'click', function(){
			gallery.pause();
		});
		this.listen('.btnZoom', 'click', function(e){
			targetIndex = $(this).attr('target');
			if(gallery.data[targetIndex]['imageOrg'].match(/http/gi)) {
				path = gallery.data[targetIndex]['imageOrg'];
				path2 = gallery.data[targetIndex]['image'];
			}else{
				path = rvsWebRoot +'/'+ gallery.data[targetIndex]['imageOrg'];
				path2 = rvsWebRoot +'/'+ gallery.data[targetIndex]['image'];
			}
			var imageThem = new Image();
			imageThem.src = path;
			var imageThem2 = new Image();
			imageThem2.src = path2;
			if (imageThem.complete){
				window.open(path, 'popup'+targetIndex, "width="+imageThem.width+",height="+imageThem.height+",status=0,toolbar=0,menubar=0,location=0,scrollbars=1");				
			} else {
				window.open(path2, 'popup'+targetIndex, "width="+imageThem2.width+",height="+imageThem2.height+",status=0,toolbar=0,menubar=0,location=0,scrollbars=1");							
			}			
		});
		this.listen('.btnMailToFriend', 'click', function() {
			if (this.getAttribute('typelink') == 'album-mf') {
					window.location = "mailto:?subject="+txtCallMailToFriend+"&body="+window.location.href;
			} else {
					window.location = "mailto:?subject="+txtCallMailToFriend+"&body="+callMailToFriend;
			}
		});
		this.listen('.linkNW','click', function(){
			stageSrc = gallery.options.stage_ctrl; // album,image
			var shareSocial =  new Galleria.RvsBuildin(galleryId, {
				'serviceFile' : urlAjax,
				'builG': false
				});
			typelink = $(this).attr('typelink');
			optSocial = {
					optType: typelink // fb=facebook, tw=twitter, sp=myspace
		    }
			if (stageSrc == 'album') {
					optSocial.optMode = 'ga';
					optSocial.optPath = $('#link-network').attr('sharegallery');
					shareSocial.shareNetwork(optSocial);
			} else {
				    optSocial.optMode = 'im';
					var imgNormal = new Image();
					imgNormal.src = rvsWebRoot +'/'+ $('#link-network').attr('shareOrgImg');
					imgNormal.onerror=function(){
						optSocial.optPath = $('#link-network').attr('shareimg');
						shareSocial.shareNetwork(optSocial);
					};
					imgNormal.onload = function(){
						optSocial.optPath = $('#link-network').attr('shareOrgImg');
						shareSocial.shareNetwork(optSocial);
					};
					
			}			

		});

        /// end fn rvsrun
		if(o.callrun == 'rvsrun') {
			this.runFolder();
		} else { 
        if (this.data.length != 0 ) {
        for( var i=0; this.data[i]; i++ ) {
            var thumb;
            if (o.thumbnails === true) {
                thumb = new Picture(i);
                var src = this.data[i].thumb || this.data[i].image;
               // this.data[i].dis =this.data[i].dis || this.data[i].nameimg ;
                
        	    randDate = new Date();
     		    cache = "?cache=" + randDate.getTime();
     		    src +=cache;
                
                this.get( 'thumbnails' ).appendChild( thumb.elem );
                
                w = this.getStyle(thumb.elem, 'width', true);
                h = this.getStyle(thumb.elem, 'height', true);
                
                // grab & reset size for smoother thumbnail loads
                if (o.thumb_fit && o.thum_crop !== true) {
                    this.setStyle(thumb.elem, { width:0, height: 0});
                }

                thumb.load(src, this.proxy(function(e) {
                    var orig = e.target.width;
                    e.scope.scale({
                        width: w,
                        height: h,
                        crop: o.thumb_crop,
                        margin: o.thumb_margin,
                        complete: this.proxy(function() { 
                            var top = ['left', 'top'];
                            var arr = ['Height', 'Width'];
                            this.loop(arr, function(m,i) {
                                if ((!o.thumb_crop || o.thumb_crop == m.toLowerCase()) && o.thumb_fit) {
                                    var css = {};
                                    var opp = arr[Math.abs(i-1)].toLowerCase();
                                    css[opp] = e.target[opp];
                                    this.setStyle(e.target.parentNode, css);
                                    var css = {};
                                    css[top[i]] = 0;
                                    this.setStyle(e.target, css);
                                }
                                e.scope['outer'+m] = this[m.toLowerCase()](e.target.parentNode, true);
                            });
                            // set high quality if downscale is moderate
                            this.toggleQuality(e.target, o.thumb_quality === true || ( o.thumb_quality == 'auto' && orig < e.target.width * 3 ));
                            this.trigger({
                                type: G.THUMBNAIL,
                                thumbTarget: e.target,
                                thumbOrder: e.scope.order
                            });
                        })
                    });
                }));

                if (o.preload == 'all') {
                    thumb.add(this.data[i].image);
                }
            } else if (o.thumbnails == 'empty') {
                thumb = {
                    elem:  this.create('div','galleria-image'),
                    image: this.create('span','img')
                };
                thumb.elem.appendChild(thumb.image);
                this.get( 'thumbnails' ).appendChild( thumb.elem );
            } else {
                thumb = {
                    elem: false,
                    image: false
                }
            }
            var activate = this.proxy(function(e) {
                this.pause();
                e.preventDefault();
                var ind = e.currentTarget.rel;
                if (this.active !== ind) {
                    this.show( ind );
                }
            });
            if (o.thumbnails !== false) {
                thumb.elem.rel = i;
                this.listen(thumb.elem, 'click', activate);
            }
            if (o.link_source_images && o.keep_source && this.data[i].elem) {
                this.data[i].elem.rel = i;
                this.listen(this.data[i].elem, 'click', activate);
            }

            this.push(thumb, this.thumbnails);

        }
        }
        }
        this.setStyle( this.get('thumbnails'), { opacity: 0 } );
        
        if (o.height && o.height != 'auto') {
            this.setStyle( this.get('container'), { height: o.height })
        }
        
        this.wait(function() {
            // the most sensitive piece of code in Galleria, we need to have all the meassurements right to continue
            var cssHeight = this.getStyle( this.get( 'container' ), 'height', true );
            this.stageWidth = this.width(this.get( 'stage' ));
            this.stageHeight = this.height( this.get( 'stage' ));
            if (this.stageHeight < 50 && o.height == 'auto') {
                // no height detected for sure, set reasonable ratio (16/9)
                this.setStyle( this.get( 'container' ),  { 
                    height: Math.round( this.stageWidth*9/16 ) 
                } );
                this.stageHeight = this.height( this.get( 'stage' ));
            }
            return this.stageHeight && this.stageWidth;
        }, function() {
            this.listen(this.get('image-nav-right'), 'click', this.proxy(function(e) {
                if (o.clicknext) {
                    e.stopPropagation();
                }
                this.pause();
                this.next();
            }));
            this.listen(this.get('image-nav-left'), 'click', this.proxy(function(e) {
                if (o.clicknext) {
                    e.stopPropagation();
                }
                this.pause();
                this.prev();
            }));
            this.setStyle( this.get('thumbnails'), { opacity: 1 } );
            this.trigger( G.READY );
        }, function() {
            G.raise('Galleria could not load properly. Make sure stage has a height and width.');
        }, 5000);
    },
    /// START Status show page
    showstage : function(){
    	var o = this.options;
    	
    	if(o.stage_ctrl == 'image'){
    		this.$('album-stage').css({'visibility':'hidden'});
    		this.$('album-thumbnails-container').css({'visibility':'hidden'});
    		this.$('album-info').css({'visibility':'hidden'}); /// desc album
    		this.$('album-stage-header').hide(); /// zoomin zoomout btn fb,tw,sp,email
    		this.$('album-stage-header-info').hide(); /// name album
    		
            this.$('stage').css({'visibility':'visible'});
    		this.$('thumbnails-container').css({'visibility':'visible'});
    		this.$('info').css({'visibility':'visible'});
    		this.$('image-info').css({'visibility':'visible','z-index':99999});
    		this.$('stage-header').show();
    	} else {
    		this.$('album-stage').css({'visibility':'visible'});
    		this.$('album-thumbnails-container').css({'visibility':'visible'});
    		this.$('album-info').css({'visialbum-stage-header-infobility':'visible'});
    		this.$('album-stage-header').show();
    		this.$('album-stage-header-info').show();
    		
        this.$('stage').css({'visibility':'hidden'});
    		this.$('thumbnails-container').css({'visibility':'hidden'});
    		this.$('info').css({'visibility':'hidden'});
    		this.$('image-info').css({'visibility':'hidden'});
    		this.$('stage-header').hide();
    	}
    },
  /// END Status show page
    
    /// start function rvsitebuilder make
runFolder : function(i){
    //	swreset();startstop(); // ไว้จับเวลา
	var o = this.options;
	g = this;
	this.folder_source = o.folder_source;
	this.dataEmpty = o.dataEmpty;
	this.currentDatas = o.currentDatas;
	
	/// start move from rvsrun
	if(aConf.showAlbumDesc == true) {
		this.currentDatas.albumDesc = this.currentDatas.albumDesc || '';
		this.get('album-info').innerHTML = '<span>'+this.currentDatas.albumDesc+'</span>';
	} else {
		this.get('album-info').style.display='none';
	}
	   if(this.currentDatas.albumName) {
	    	txtAlbumName = this.currentDatas.albumName+' album' ;
	    } else { 
	     	txtAlbumName = '';
	     }
		this.get('album-stage-header-info').innerHTML = '<div align="center">'+txtAlbumName+'</div>';
	/// end move from rvsrun
	
	var activateUpOneFolder = this.proxy(function(e) {
	 	aOneLevel = this.currentDatas.currentPathFolder.split('/');
	 	var upOneLevelInd = aOneLevel.length - 1;
	 	aOneLevel.splice(upOneLevelInd, upOneLevelInd);
	 	var currentPath = aOneLevel.join('/');
	 	// fixed problem  encode more than 2 loop tanawat nipaporn
        try{
            currentPath = encodeURI(decodeURI(currentPath));
        }catch(e) {
            currentPath = encodeURI(currentPath);
        }
        //end  fixed problem  encode more than 2 loop tanawat nipaporn
	 	urlUplevel = '&currentPathFolder='+currentPath+'&albumId='+encodeURI(this.currentDatas.albumId);
	 	loadGalleria(urlUplevel,true);     	
    }); 
	for ( var i = 0; this.folder_source[i]; i++) {
		thumbAlbumFolder = new Picture(i);//title
		var src = this.folder_source[i].thumb || this.folder_source[i].image;
		srcTitle = this.folder_source[i].title;
		this.get('album-stage-image').appendChild(thumbAlbumFolder.elem);
		w = this.getStyle(thumbAlbumFolder.elem, 'width', true);
		h = this.getStyle(thumbAlbumFolder.elem, 'height', true);
		thumbAlbumFolder.load(src,this.proxy(
				function(e) {
						var orig = e.target.width;
						e.target.setAttribute('folder','true');
						e.scope.scale( {
								width : opsitionImage,
								height : opsitionImage,
								crop : o.thumb_crop,
								margin : o.thumb_margin,
								complete : this.proxy(function() {
									var top = ['left','top' ];
									var arr = ['Height','Width' ];
									this.loop(arr,function(m,i) {
										if ((!o.thumb_crop || o.thumb_crop == m.toLowerCase())&& o.thumb_fit) {
											var css = {};
											var opp = arr[Math.abs(i - 1)].toLowerCase();
											css[opp] = e.target[opp];
											this.setStyle(e.target.parentNode,css);
											var css = {};
											css['width'] = 100;
											css['height'] = 100;
											css[top[i]] = 0;
											this.setStyle(e.target,css);
											}
										e.scope['outer' + m] = this[m.toLowerCase()](e.target.parentNode,true);});
										this.toggleQuality(e.target,o.thumb_quality === true || (o.thumb_quality == 'auto' && orig < e.target.width * 3));
										this.trigger( {
											type : G.THUMBNAIL,
											thumbTarget : e.target,
											thumbOrder : e.scope.order
										});
								})
						});
		}));	
		
		FolderName = document.createElement('DIV');
		FolderName.style.color = "#5c5c5c";
		FolderName.style.overflow = "hidden";
		FolderName.innerHTML = srcTitle;
		thumbAlbumFolder.elem.align = "center"; 
		thumbAlbumFolder.elem.appendChild(FolderName);
		
		this.setTitle(thumbAlbumFolder.elem, srcTitle);
		var activate = this.proxy(function(e) {
			currentPath = this.currentDatas.currentPathFolder || '';
			// fixed problem  encode more than 2 loop tanawat nipaporn
            try{
                currentPath = encodeURI(decodeURI(currentPath));
            }catch(e) {
                currentPath = encodeURI(currentPath);
            }
           //end  fixed problem  encode more than 2 loop tanawat nipaporn
			urllinkAjax = '&currentPathFolder='+currentPath + '/' +encodeURI(this.folder_source[e.currentTarget.rel].path)+
					'&albumId='+encodeURI(this.currentDatas.albumId);
			loadGalleria(urllinkAjax,true);
		});

		typefolder  = this.folder_source[i].type;
		if(typefolder == 'uf'){
			thumbAlbumFolder.elem.rel = i;
			this.listen(thumbAlbumFolder.elem, 'click', activateUpOneFolder);
		} else {
			if (o.thumbAlbumFolder !== false) {
				thumbAlbumFolder.elem.rel = i;
				this.listen(thumbAlbumFolder.elem, 'click', activate);
			}
		}
		if (o.link_source_images && o.keep_source && this.folder_source[i].elem) {
			this.folder_source[i].elem.rel = i;
			this.listen(this.folder_source[i].elem, 'click', activate);
		}
	}
	  initPagination(this.data.length); /// pager
      if (this.data.length != 0 ) {
    		thumbAlbumImg = [];
			opst = (opsitionImage == undefined) ? aConf.sizeThumb : opsitionImage;
			//opst = 120;
			loadingSRC = SGL_JS_WEBROOT+'/js/photogallery/themes/rvsdefault/images/loading02.gif';
			loadingBackground = 'url('+loadingSRC+') no-repeat center';
    	  		for(i=0;this.data[i];i++) {
    	    		thumbAlbumImg[i] = new Picture(i);
    	    		thumbAlbumImg[i].elem.style.background = loadingBackground;
    	    		thumbAlbumImg[i].elem.className=thumbAlbumImg[i].elem.className+' displaynone';
    	    		thumbAlbumImg[i].elem.style.width = opst+'px';
    	    		thumbAlbumImg[i].elem.style.height = opst+'px';
    	    		this.get( 'album-stage-image' ).appendChild(thumbAlbumImg[i].elem);
    	  		}
    	  this.runDef(0);  
      }else{
    	 // startstop();
      }
    },
    
    runDef : function(i) {
    	var o = this.options;
    	if (o.thumbnails === true) {
    		thumb = new Picture(i);
    		//thumbAlbumImg = new Picture(i);
    		var src = this.data[i].thumb || this.data[i].image;
    		srcTitle = this.data[i].title;
 		   
    		randDate = new Date();
		    cache = "?cache=" + randDate.getTime();
		    src +=cache;
		   
    		this.get( 'thumbnails' ).appendChild( thumb.elem );
    		thumb.elem.className += ' setremove' 
    		thumbAlbumImg[i].elem.className += ' displaynone' 
    		// grab & reset size for smoother thumbnail loads
    			/*
    		if (o.thumb_fit && o.thum_crop !== true) {
    			this.setStyle(thumbAlbumImg[i].elem, { width:0, height: 0});
    		}
    		*/
    		oStyle =  { };
    		if(i >= aConf.thumbPerPage) {
    			oStyle =  { display:'none'};
    		} 
    		this.setStyle(thumbAlbumImg[i].elem,oStyle);
    		thumb.load(src, this.proxy(function(e) {
    			var orig = e.target.width;
    			e.scope.scale({
    				crop: o.thumb_crop,
    				margin: o.thumb_margin,
    				complete: this.proxy(function() {
    					var top = ['left', 'top'];
    					var arr = ['Height', 'Width'];
    					this.loop(arr, function(m,i) {
    						if ((!o.thumb_crop || o.thumb_crop == m.toLowerCase()) && o.thumb_fit) {
    							var css = {};
    							var opp = arr[Math.abs(i-1)].toLowerCase();
    							css[opp] = e.target[opp];
    							this.setStyle(e.target.parentNode, css);
    							var css = {};
    							css[top[i]] = 0;
    							this.setStyle(e.target, css);
    						}
    						e.scope['outer'+m] = this[m.toLowerCase()](e.target.parentNode, true);
    					});
    					// set high quality if downscale is moderate
    					this.toggleQuality(e.target, o.thumb_quality === true || ( o.thumb_quality == 'auto' && orig < e.target.width * 3 ));
    					this.trigger({
    						type: G.THUMBNAIL,
    						thumbTarget: e.target,
    						thumbOrder: e.scope.order
    					});
    					
    				})/// close complete
    			});
    		}));
    		thumbAlbumImg[i].load(src, this.proxy(function(e) {
    			cssAlbum = {};
    			this.setStyle(e.target.parentNode, cssAlbum);
    			var orig = e.target.width;
    			e.scope.scale({
    				width : opsitionImage,
    				height : opsitionImage,
    				crop: o.thumb_crop,
    				margin: o.thumb_margin,
    				complete: this.proxy(function() {
    					var top = ['left', 'top'];
    					var arr = ['Height', 'Width'];
    					this.loop(arr, function(m,i) {
    						if ((!o.thumb_crop || o.thumb_crop == m.toLowerCase()) && o.thumb_fit) {
    							var css = {};
    							var opp = arr[Math.abs(i-1)].toLowerCase();
    							css[opp] = e.target[opp];
    							this.setStyle(e.target.parentNode, css);
    							var css = {};
    							css[top[i]] = 0;
    							this.setStyle(e.target, css);
    						}
    						e.scope['outer'+m] = this[m.toLowerCase()](e.target.parentNode, true);
    					});
    					// set high quality if downscale is moderate
    					this.toggleQuality(e.target, o.thumb_quality === true || ( o.thumb_quality == 'auto' && orig < e.target.width * 3 ));
    					this.trigger({
    						type: G.THUMBNAIL,
    						thumbTarget: e.target,
    						thumbOrder: e.scope.order
    					});
    					e.target.parentNode.style.background = "";
    					e.target.parentNode.style.width = opsitionImage+'px';
    					e.target.style.width = opsitionImage+'px';;
    				})
    			});
    		}));/// close thumbAlbumImg

    this.setTitle(thumbAlbumImg[i].elem, srcTitle);
    var gallery = this;
    var activate = this.proxy(function(e) {
    	o.stage_ctrl ='image';
    	this.showstage();
    	this.pause();
    	e.preventDefault();
    	var ind = e.currentTarget.rel;
    	if(o.ctrl_autoplay == true) {
    		setTimeout(function(){
    			gallery.options.transition = aConf.slideEffect;
    			gallery.play(aConf.slideDelay); 
    		},aConf.slideDelay);// auto play
    	}
    	this.show( ind );/// fix bug selectec (ind=0, img active = 0)
    });
    if (o.thumbAlbumImg !== false) {
    	thumbAlbumImg[i].elem.rel = i;
    	this.listen(thumbAlbumImg[i].elem, 'click', activate);
    }
    if (o.link_source_images && o.keep_source && this.data[i].elem) {
    	this.data[i].elem.rel = i;
    	this.listen(this.data[i].elem, 'click', activate);
    }
    if (o.preload == 'all') {
    	thumb.add(this.data[i].image);
    	thumbAlbumImg[i].add(this.data[i].image);
    }
    } else if (o.thumbnails == 'empty') {
    	thumb = {
    			elem: this.create('div','galleria-image'),
    			image: this.create('span','img')
    	};
    	thumb.elem.appendChild(thumb.image);
    	this.get( 'thumbnails' ).appendChild( thumb.elem );
    } else {
    	thumb = {
    			elem: false,
    			image: false
    	}
    }
    var activate = this.proxy(function(e) {
    	this.pause();
    	e.preventDefault();
    	var ind = e.currentTarget.rel;
    	if (this.active !== ind) {
    		this.show( ind );
    	}
    });
    if (o.thumbnails !== false) {
    	thumb.elem.rel = i;
    	this.listen(thumb.elem, 'click', activate);
    }
    if (o.link_source_images && o.keep_source && this.data[i].elem) {
    	this.data[i].elem.rel = i;
    	this.listen(this.data[i].elem, 'click', activate);
    }
    this.push(thumb, this.thumbnails );
    g = this;
    if(i<this.data.length -1) {
    	setTimeout(function(){
    		i+=1;
    		g.runDef(i);
    	},50)
    }else{
    //alert('end'); //startstop(); // ไว้จับเวลา
        this.$('thumbnails').children().hover(function() {
            $(this).not('.active').children().stop().fadeTo(100, 1);
        }, function() {
            $(this).not('.active').children().stop().fadeTo(400, .4);
        }).not('.active').children().css('opacity',.4);
    }
    },
/// end function rvsitebuilder make
	rvsrun : function() {
		var o = this.options;
		/************* class CSS *********************************
		 * galleria-album-stage galleria-album-thumbnails-container
		 * galleria-image-info,galleria-album-info // ไว้ใส่ description ของ photo และ อั้มบั้ม
		 * album-stage-header-info // ไว้ใส่ ชื่ออัลบั้ม
		 * stage-header : album-stage-header  // ไว้ใส่ btn (run effect fullscreen  pager)
		 * image-info [image-info-left,image-info-center,image-info-right ] // ไว้ใส่พวก เลขที่หน้า , description image , view image
		 ***********************************************/
		// / Create album-stage
		elems = 'stage-header album-stage album-stage-header album-stage-header-info album-thumbnails-container album-info '
				+ 'album-stage-header-left album-stage-header-center album-stage-header-right '
				+ 'album-stage-image '
				+ 'stage-header-left stage-header-center stage-header-right '
				+ 'image-info image-info-left image-info-center image-info-right '
				+ 'album-thumbnails-list album-thumbnails '
				+ 'album-thumbnails-container album-thumb-nav-left album-thumbnails-list album-thumb-nav-right';
		elems = elems.split(' ');
		this.loop(elems, function(blueprint) {
			this.dom[blueprint] = this.create('div',
					'galleria-' + blueprint);
		});
		elems = {
			'stage-header' : [ 'stage-header-left',
					'stage-header-center', 'stage-header-right'],
			'album-stage-header' : [ 'album-stage-header-left',
			         'album-stage-header-center',
					 'album-stage-header-right' ],
		    'image-info' : [ 'image-info-left',
		             'image-info-center',
		             'image-info-right'],
			'stage' : [ 'stage-header','stage-image'],
			'album-thumbnails-list' : [ 'album-thumbnails' ],
			'album-thumbnails-container' : [
					'album-thumb-nav-left',
					'album-thumbnails-list',
					'album-thumb-nav-right' ],
			'album-stage' : ['album-stage-image'],
			'container' : ['stage','album-stage-header','image-info','stage-header','album-stage','album-stage-header-info','album-info',
			               'album-thumbnails-container']
		};

		this.append(elems);
        /// start effect auto run display image
		objSelectDelay = this.create('select','selectDelay');
		objSelectDelay.id = objSelectDelay.className  = objSelectDelay.name = 'selectDelay' 
		for(i=0;o.rvsDelay[i];i++) {
			objOptionDelay = this.create('option');
			objOptionDelay.value = o.rvsDelay[i];
			if(o.rvsDelay[i] == aConf.slideDelay){
				objOptionDelay.setAttribute('selected','selected');
			}
			objOptionDelay.innerHTML = (o.rvsDelay[i]/1000)+'sec';
			objSelectDelay.appendChild(objOptionDelay)
		}

		objSelectEffect = this.create('select','selectEffect');
		objSelectEffect.id =  objSelectEffect.className = objSelectEffect.name = 'selectEffect' 
		for(i=0;o.rvsEffect[i];i++) {
			objOptionEffect = this.create('option');
			objOptionEffect.innerHTML = objOptionEffect.text = o.rvsEffect[i];
			if(o.rvsEffect[i] == aConf.slideEffect){
			}
			objSelectEffect.appendChild(objOptionEffect)
		}
		objbtnPlay = this.create('input');
		objbtnPlay.id =objbtnPlay.className = objbtnPlay.name = 'btnPlay';
		objbtnPlay.type = 'button';

		var txtLinkSocial = '';
		
		objlinkFb = this.create('a');
		objlinkFb.href = 'javascript:void(0)';
		objlinkFb.className = 'btnfacebook linkNW';
		objlinkFb.setAttribute('typelink','fb');
		if(o.conf_fb == false) {
			objlinkFb.style.display = 'none';
		} else {
			txtLinkSocial += '<a href="javascript:void(0)" class="btnfacebook linkNW"  typelink="fb"></a>';
		}
		
		objlinkTw = this.create('a');
		objlinkTw.href = 'javascript:void(0)';
		objlinkTw.className = 'btntwitter linkNW';
		objlinkTw.setAttribute('typelink','tw');
		if(o.conf_tw == false) {
			objlinkTw.style.display = 'none';
		} else {
			txtLinkSocial += '<a href="javascript:void(0)" class="btntwitter linkNW"  typelink="tw"></a> ';
		}
		
		objlinkSp = this.create('a');
		objlinkSp.href = 'javascript:void(0)';
		objlinkSp.className = 'btnmyspace linkNW';
		objlinkSp.setAttribute('typelink','sp');
		if(o.conf_sp == false) {
			objlinkSp.style.display = 'none';
		} else {
			txtLinkSocial += '<a href="javascript:void(0)" class="btnmyspace linkNW"  typelink="sp"></a>';
		}
		
		bjlinkMailToF = this.create('a');
		bjlinkMailToF.href = 'javascript:void(0)';
		bjlinkMailToF.className = 'btnMailToFriend';
		bjlinkMailToF.setAttribute('typelink','mf');
		if(o.conf_mail == false) {
			bjlinkMailToF.style.display = 'none';
		} else {
			txtLinkSocial += '<a href="javascript:void(0)" class="btnMailToFriend"  typelink="album-mf"></a>';
		}
		
		objbtnPause = this.create('input');
		objbtnPause.id =objbtnPause.className = objbtnPause.name = 'btnStop';
		objbtnPause.type = 'button';
		
		objbtnOrg= this.create('input');
		objbtnOrg.id =objbtnOrg.className = objbtnOrg.name = 'btnZoom';
		objbtnOrg.type = 'button';
		//Start check view Image Full Size
		 if((aConf.viewImageFullSize === false || aConf.viewImageFullSize === 'false') && (aConf.viewImageFullSize != undefined)) {
			 objbtnOrg.style.display = 'none';
		 }
		//End  check view Image Full Size
		/// end effect auto run display image
		
/**********************************
		class="stage-header-left"> : insert button (top level,back to album)
		class="stage-header-center">:insert name album
		class="album-info"> : description album
************************************/

		this.get('album-stage-header-left').innerHTML = '<div class="bdrslidederbar">'+
																'<div class="bgslidederbar"><img src="'+SGL_JS_WEBROOT+'/js/photogallery/themes/rvsdefault/images/small_slidebar.gif" alt="" width="11" height="9" class="left" hspace="2" />'+
																'<span class="left">'+
																'<div id="slider"style="width:150px;"></div>'+
																'</span>'+
																'<img src="'+SGL_JS_WEBROOT+'/js/photogallery/themes/rvsdefault/images/big_slidebar.gif" alt="" width="16" height="13" hspace="2" /></div>'+
																'</div>'+txtLinkSocial;
		this.get('stage-header-right').innerHTML = '<input type="button" title="'+txtFullscreen+'" class="btn-fullscreen" value="&nbsp;" />';
		this.get('album-stage-header-right').innerHTML = '<span id="Pagination"></span><input type="button" title="'+txtFullscreen+'" class="btn-fullscreen" value="&nbsp;" />';
		
		this.get('stage-header-left').innerHTML = '<input type="button" title="'+txtbackToTopLevel+'" class="btn-top-level" value="&nbsp;" />'+
																				'<input type="button"  title="'+txtbackToFolder+'" class="btn-next-level" value="&nbsp;"/>';
		this.get('stage-header-left').appendChild(objSelectDelay);
		this.get('stage-header-left').appendChild(objSelectEffect);
		this.get('stage-header-left').appendChild(objbtnPlay);
		this.get('stage-header-left').appendChild(objbtnPause);
		this.get('stage-header-left').appendChild(objlinkFb);
		this.get('stage-header-left').appendChild(objlinkTw);
		this.get('stage-header-left').appendChild(objlinkSp);
		this.get('stage-header-left').appendChild(bjlinkMailToF);
		this.get('image-info-right').appendChild(objbtnOrg);
		
		o.stage_ctrl ='album';
		//o.stage_ctrl ='image';

		this.showstage();

		// set data gallery
		this.folder_source = o.folder_source;
		this.dataEmpty = o.dataEmpty;


	/// list thumbnail
		for ( var i = 0; this.galleryData[i]; i++) {
			var thumbGallery;
			if (o.thumbnails === true) {
				thumbGallery = new Picture(i);
				var src = this.galleryData[i].thumb || this.galleryData[i].image;
				srcTitle = this.galleryData[i].title;
				
	    		randDate = new Date();
	 		    cache = "?cache=" + randDate.getTime();
	 		    src +=cache;
				
				this.get('album-thumbnails').appendChild(thumbGallery.elem);
				 w = this.getStyle(thumbGallery.elem, 'width', true);
				 h = this.getStyle(thumbGallery.elem, 'height', true);
				// grab & reset size for smoother thumbnail loads
				 positionXY = ($.browser.msie || $.browser.safari || $.browser.opera) ? 106 : 0;
				 if (o.thumb_fit && o.thum_crop !== true) {
					 this.setStyle(thumbGallery.elem, {
						 width : positionXY,
						 height : positionXY
					 });
				 } 
				coverSRC = SGL_JS_WEBROOT+'/js/photogallery/themes/rvsdefault/images/icon_gallery_cover.gif';
				this.setStyle(thumbGallery.elem, {
					'background-image':'url('+coverSRC+')'
				});
				thumbGallery.load(src,this.proxy(
						function(e) {
								var orig = e.target.width;
								e.scope.scale( {
										width : w,
										height : h,
										crop : o.thumb_crop,
										margin : o.thumb_margin,
										complete : this.proxy(function() {
											var top = ['left','top' ];
											var arr = ['Height','Width' ];
											this.loop(arr,function(m,i) {
												if ((!o.thumb_crop || o.thumb_crop == m.toLowerCase())&& o.thumb_fit) {
													var css = {};
													var opp = arr[Math.abs(i - 1)].toLowerCase();
													css[opp] = e.target[opp];
													this.setStyle(e.target.parentNode,css);
													var css = {};
													css[top[i]] =0;
													this.setStyle(e.target,css);
													}
												/// new design album
												$(e.target).css({
														'height':'68px',
														'width':'85px',
														'top':'5px',
														'right':'0px',
														'left':'16px'
												});
												e.scope['outer' + m] = this[m.toLowerCase()](e.target.parentNode,true);});
												// set
												// high
												// quality
												// if
												// downscale
												// is
												// moderate
												this.toggleQuality(e.target,o.thumb_quality === true || (o.thumb_quality == 'auto' && orig < e.target.width * 3));
												this.trigger( {
													type : G.THUMBNAILALBUM,
													thumbTarget : e.target,
													thumbOrder : e.scope.order
												});
										})
									});
								}));

				if (o.preload == 'all') {
					thumbGallery.add(this.data[i].image);
				}
			} else if (o.thumbnails == 'empty') {
				thumbGallery = {
					elem : this.create('div', 'galleria-image'),
					image : this.create('span', 'img')
				};
				thumbGallery.elem.appendChild(thumbGallery.image);
				this.get('album-thumbnails')
						.appendChild(thumbGallery.elem);
			} else {
				thumbGallery = {
					elem : false,
					image : false
				}
			}
			// / START TODO

    		this.setTitle(thumbGallery.elem, srcTitle);
			var activate = this.proxy(function(e) {
				$(e.currentTarget).addClass('active').siblings('.active').removeClass('active').children().css('opacity',.4);
				var albumId = this.galleryData[e.currentTarget.rel].album_id;
				 loadGalleria('&albumId='+albumId,true);
			});
			// / END TODO
			if (o.thumbnails !== false) {
				thumbGallery.elem.rel = i;
				this.listen(thumbGallery.elem, 'click', activate);
			}
			if(i == 0){
				$(thumbGallery.elem).addClass('active').siblings('.active').removeClass('active').children().css('opacity',.4);
			}
			if (o.link_source_images && o.keep_source
					&& this.data[i].elem) {
				this.data[i].elem.rel = i;
				this.listen(this.data[i].elem, 'click', activate);
			}
			  this.push(thumbGallery, this.thumbnailsAlbum );
			 // alert(print_r(this.thumbnailsAlbum))
		//	this.bind(G.THUMBNAILALBUM, this.parseCarouselAlbum);
		}/// End for thumnails gallery
		
		
        this.$('album-thumbnails').children().hover(function() {
            $(this).not('.active').children().stop().fadeTo(100, 1);
        }, function() {
            $(this).not('.active').children().stop().fadeTo(400, .4);
        }).not('.active').children().css('opacity',.4);
        this.setStyle(this.get('thumbnails'), {
			opacity : 0
		});

		if (o.height && o.height != 'auto') {
			this.setStyle(this.get('container'), {
				height : o.height
			})
		}
		this.wait(function() {
			// the most sensitive piece of code in
			// Galleria, we need to have all the
			// meassurements right to continue
			var cssHeight = this.getStyle(this.get('container'), 'height',true);
			this.stageWidth = this.width(this.get('stage'));
			this.stageHeight = this.height(this.get('stage'));
			if (!this.stageHeight && o.height == 'auto') {
				// no height detected for sure, set
				// reasonable ratio (16/9)
				this.setStyle(this.get('container'),{
						height : Math.round(this.stageWidth * 9 / 16)
				});
				this.stageHeight = this.height(this.get('stage'));
			}
			return this.stageHeight && this.stageWidth;
		},
		function() {},
		function() {
			G.raise('Galleria could not load properly. Make sure stage has a height and width.');
		}, 5000);
						
		// end
	},
    
    mousePosition : function(e) {
        return {
            x: e.pageX - this.$('stage').offset().left + jQuery(document).scrollLeft(),
            y: e.pageY - this.$('stage').offset().top + jQuery(document).scrollTop()
        };
    },
    
    addPan : function(img) {
        var c = this.options.image_crop;
        if ( c === false ) {
            return;
        }
        if (this.options.image_crop === false) {
            return;
        }
        img = img || this.controls.getActive().image;
        if (img.tagName.toUpperCase() != 'IMG') {
            G.raise('Could not add pan');
        }
        
        var x = img.width/2;
        var y = img.height/2;
        var curX = destX = this.getStyle(img, 'left', true) || 0;
        var curY = destY = this.getStyle(img, 'top', true) || 0;
        var distX = 0;
        var distY = 0;
        var active = false;
        var ts = new Date().getTime();
        var calc = this.proxy(function(e) {
            if (new Date().getTime() - ts < 50) {
                return;
            }
            active = true;
            x = this.mousePosition(e).x;
            y = this.mousePosition(e).y;
        });
        var loop = this.proxy(function(e) {
            if (!active) {
                return;
            }
            distX = img.width - this.stageWidth;
            distY = img.height - this.stageHeight;
            destX = x / this.stageWidth * distX * -1;
            destY = y / this.stageHeight * distY * -1;
            curX += (destX - curX) / this.options.image_pan_smoothness;
            curY += (destY - curY) / this.options.image_pan_smoothness;
            
            if (distY > 0) {
            	
            	//this.setStyle(img, { top: Math.max(distY*-1, Math.min(0, curY)) });
            	
            	if (jQuery(document).scrollTop() > 0) {
            		resPosition = - (( (y - parseInt(jQuery(document).scrollTop()) )  / this.stageHeight ) * img.height);
            	} else {
            		resPosition = - (( y  / this.stageHeight ) * img.height);
            	}
            	
            	resLower = Math.max(distY*-1, Math.min(0, curY));
            	resPosition = (resPosition > resLower) ? resPosition : resLower;
            	
            	this.setStyle(img, { top: resPosition  });
            	
            }
            
            
            if (distX > 0) {
                this.setStyle(img, { left: Math.max(distX*-1, Math.min(0, curX)) });
            }
            
        });
        this.forget(this.get('stage'), 'mousemove');
        this.listen(this.get('stage'), 'mousemove', calc);
        this.addTimer('pan', loop, 30, true);
    },
    
    removePan: function() {
        this.forget(this.get('stage'), 'mousemove');
        this.clearTimer('pan');
    },
    /// start add nav thumb album

    parseCarouselAlbum : function(e) {
        var w = 0;
        var h = 0;
        var hooks = [0];
       
        this.loop(this.thumbnailsAlbum, function(thumb,i) {
            if (thumb.ready) {
                w += thumb.outerWidth || this.width(thumb.elem, true);
                //$('#debug').html( thumb.outerWidth+':::'+this.width(thumb.elem, true));
                hooks[i+1] = w;
                h = Math.max(h, this.height(thumb.elem));
            }
        });
        this.toggleClass(this.get('album-thumbnails-container'), 'galleria-carousel', w > this.stageWidth);
        this.setStyle(this.get('album-thumbnails-list'), {
            overflow:'hidden',
            position: 'relative' // for IE Standards mode
        });
        this.setStyle(this.get('album-thumbnails'), {
            width: w,
            height: h,
            position: 'relative',
            overflow: 'hidden'
        });
        if (!this.carousel_album) {
            this.initCarouselAlbum();
        }
        this.carousel_album.max = w;
       
        this.carousel_album.hooks = hooks;
        this.carousel_album.width = this.width(this.get('album-thumbnails-list'));
        this.carousel_album.setClasses();
    },
    
    initCarouselAlbum : function() {
        var c = this.carousel_album = {
            right: this.get('album-thumb-nav-right'),
            left: this.get('album-thumb-nav-left'),
            update: this.proxy(function() {
                this.parseCarouselAlbum();
                // todo: fix so the carousel moves to the left
            }),
            width: 0,
            current: 0,
            set: function(i) {
                i = Math.max(i,0);
                while (c.hooks[i-1] + c.width > c.max && i >= 0) {
                    i--;
                }
                c.current = i;
                c.animate();
            },
            hooks: [],
            getLast: function(i) {
                i = i || c.current
                
                return i-1;
            },
            follow: function(i) {
                if (i == 0 || i == c.hooks.length-2) {
                    c.set(i);
                    return;
                }
                var last = c.current;
                while(c.hooks[last] - c.hooks[c.current] < c.width && last<= c.hooks.length) {
                    last++;
                }
                if (i-1 < c.current) {
                    c.set(i-1)
                } else if (i+2 > last) {
                    c.set(i - last + c.current + 2)
                }
            },
            max: 0,
            setClasses: this.proxy(function() {
//                this.toggleClass( c.left, 'disabled', !c.current );
 //               this.toggleClass( c.right, 'disabled', c.hooks[c.current] + c.width > c.max );
            }),
            animate: this.proxy(function(to) {
                c.setClasses(); 
                this.animate( this.get('album-thumbnails'), {
                    to: { left: c.hooks[c.current] * -1 },
                    duration: this.options.carousel_speed,
                    easing: 'galleria',
                    queue: false
                });
            })
        };

        this.listen(c.right, 'click', this.proxy(function(e) {
            if (this.options.carousel_steps == 'auto') {
                for (var i = c.current; i<c.hooks.length; i++) {
                	hw = c.hooks[i] - c.hooks[c.current] ;
                //	$("#debug").html($("#debug").html() + c.max + ' ' + c.current+ ' ' + hw + ' > ' + c.width + '<br />');
                    if (c.hooks[i] - c.hooks[c.current] > c.width) {
                        c.set(i-2);
                        break;
                    }
                }			
            } else {
                c.set(c.current + this.options.carousel_steps);
            }
        }));
        /// ALBUMMMMM
        this.listen(c.left, 'click', this.proxy(function(e) {
        	//$("#debug").html("");
            if (this.options.carousel_steps == 'auto') {
                for (var i = c.current; i>=0; i--) {
                	if (c.hooks[c.current] - c.hooks[i] > c.width) {
                        c.set(i+2);
                        break;
                    } else if (i == 0) {
                        c.set(0);
                        break;
                    }
                }
            } else {
                c.set(c.current - this.options.carousel_steps);
            }
        }));
    },
    /// end add nav thumb album
    parseCarousel : function(e) {
        var w = 0;
        var h = 0;
        var hooks = [0];
        this.loop(this.thumbnails, function(thumb,i) {
            if (thumb.ready) {
            	
                w += thumb.outerWidth || this.width(thumb.elem, true);
                hooks[i+1] = w;
                h = Math.max(h, this.height(thumb.elem));
            }
        });
        this.toggleClass(this.get('thumbnails-container'), 'galleria-carousel', w > this.stageWidth);
        this.setStyle(this.get('thumbnails-list'), {
            overflow:'hidden',
            position: 'relative' // for IE Standards mode
        });
        this.setStyle(this.get('thumbnails'), {
            width: w,
            height: h,
            position: 'relative',
            overflow: 'hidden'
        });
        if (!this.carousel) {
            this.initCarousel();
        }
        this.carousel.max = w;
        this.carousel.hooks = hooks;
        this.carousel.width = this.width(this.get('thumbnails-list'));
        this.carousel.setClasses();
    },
    
    initCarousel : function() {
        var c = this.carousel = {
            right: this.get('thumb-nav-right'),
            left: this.get('thumb-nav-left'),
            update: this.proxy(function() {
                this.parseCarousel();
                // todo: fix so the carousel moves to the left
            }),
            width: 0,
            current: 0,
            set: function(i) {
                i = Math.max(i,0);
                while (c.hooks[i-1] + c.width > c.max && i >= 0) {
                    i--;
                }
                c.current = i;
                c.animate();
            },
            hooks: [],
            getLast: function(i) {
                i = i || c.current
                
                return i-1;
            },
            follow: function(i) {
                if (i == 0 || i == c.hooks.length-2) {
                    c.set(i);
                    return;
                }
                var last = c.current;
                while(c.hooks[last] - c.hooks[c.current] < c.width && last<= c.hooks.length) {
                    last++;
                }
                if (i-1 < c.current) {
                    c.set(i-1)
                } else if (i+2 > last) {
                    c.set(i - last + c.current + 2)
                }
            },
            max: 0,
            setClasses: this.proxy(function() {
                this.toggleClass( c.left, 'disabled', !c.current );
                this.toggleClass( c.right, 'disabled', c.hooks[c.current] + c.width > c.max );
            }),
            animate: this.proxy(function(to) {
                c.setClasses();
                this.animate( this.get('thumbnails'), {
                    to: { left: c.hooks[c.current] * -1 },
                    duration: this.options.carousel_speed,
                    easing: 'galleria',
                    queue: false
                });
            })
        };
        /// GALLERY
        this.listen(c.right, 'click', this.proxy(function(e) {
            if (this.options.carousel_steps == 'auto') {
                for (var i = c.current; i<c.hooks.length; i++) {
                //	$("#debug").html($("#debug").html() + c.max + ' ' + c.current+ ' ' + hw + ' > ' + c.width + '<br />');
                    if (c.hooks[i] - c.hooks[c.current] > c.width) {
                        c.set(i-2);
                        break;
                    }
                }
            } else {
                c.set(c.current + this.options.carousel_steps);
            }
        }));
        /// GALLERY
        this.listen(c.left, 'click', this.proxy(function(e) {
            if (this.options.carousel_steps == 'auto') {
                for (var i = c.current; i>=0; i--) {
                    if (c.hooks[c.current] - c.hooks[i] > c.width) {
                        c.set(i+2);
                        break;
                    } else if (i == 0) {
                        c.set(0);
                        break;
                    }
                }
            } else {
                c.set(c.current - this.options.carousel_steps);
            }
        }));
    },
    addElement : function() {
        this.loop(arguments, function(b) {
            this.dom[b] = this.create('div', 'galleria-' + b );
        });
        return this;
    },
    getDimensions: function(i) {
        return {
            w: i.width,
            h: i.height,
            cw: this.stageWidth,
            ch: this.stageHeight,
            top: (this.stageHeight - i.height) / 2,
            left: (this.stageWidth - i.width) / 2
        };
    },
    attachKeyboard : function(map) {
        this.keyboard.attach(map);
        return this;
    },
    detachKeyboard : function() {
        this.keyboard.detach();
        return this;
    },
    build : function() {
        this.append({
            'info-text' :
                ['info-title', 'info-description', 'info-author'],
            'info' : 
                ['info-text'],
            'image-nav' : 
                ['image-nav-right', 'image-nav-left'],
            'stage' : 
                ['images', 'loader', 'counter', 'image-nav'],
            'thumbnails-list' :
                ['thumbnails'],
            'thumbnails-container' : 
                ['thumb-nav-left', 'thumbnails-list', 'thumb-nav-right'],
            'container' : 
                ['stage', 'thumbnails-container', 'info']
        });
        
        this.current = this.create('span', 'current');
        this.current.innerHTML = '-';
       /******************************************************
        this.get('counter').innerHTML = ' / <span class="total">' + this.data.length + '</span>';
        this.prependChild('counter', this.current);
       ***************************************************** */
        /// start rv modify div
        this.get('image-info-left').innerHTML = ' / <span class="total">' + this.data.length + '</span>';
        this.prependChild('image-info-left', this.current);
        /// end rv modify div
    },
    
    appendChild : function(parent, child) {
        try {
            this.get(parent).appendChild(this.get(child));
        } catch(e) {}
    },
    
    prependChild : function(parent, child) {
        var child = this.get(child) || child;
        try {
            this.get(parent).insertBefore(child, this.get(parent).firstChild);
        } catch(e) {}
    },
    
    remove : function() {
        var a = Array.prototype.slice.call(arguments);
        this.jQuery(a.join(',')).remove();
    },
    
    append : function(data) {
        for( var i in data) {
            if (data[i].constructor == Array) {
                for(var j=0; data[i][j]; j++) {
                    this.appendChild(i, data[i][j]);
                }
            } else {
                this.appendChild(i, data[i]);
            }
        }
        return this;
    },
    
    rescale : function(width, height, callback) {
        
        var o = this.options;
        callback = this.proxy(callback);
        
        if (typeof width == 'function') {
            callback = this.proxy(width);
            width = undefined;
        }
        
        var scale = this.proxy(function() {
            this.stageWidth = width || this.width(this.get('stage'));
            this.stageHeight = height || this.height(this.get('stage'));
            this.controls.getActive().scale({
                width: this.stageWidth, 
                height: this.stageHeight, 
                crop: o.image_crop, 
                max: o.max_scale_ratio,
                min: o.min_scale_ratio,
                margin: o.image_margin,
                position: o.image_position,
                viewOrg: o.image_original  /// opt view image original
            });
            if (this.carousel) {
                this.carousel.update();
            }
            this.trigger(G.RESCALE)
            callback();
        });
        if ( G.WEBKIT && !width && !height ) {
            this.addTimer('scale', scale, 5);// webkit is too fast
        } else {
            scale.call(this); 			
        }
    },
    
    show : function(index, rewind, history) {
        if (!this.options.queue && this.queue.stalled) {
            return;
        }
        rewind = typeof rewind != 'undefined' ? !!rewind : index < this.active;
        history = history || false;
        index = Math.max(0, Math.min(parseInt(index), this.data.length - 1));
        if (!history && G.History) {
            G.History.value(index.toString());
            return;
        }
        this.active = index;
      // alert(this.data[index].dis);
        this.push([index,rewind], this.queue);
        if (!this.queue.stalled) {
        	if (this.data.length !=0) {
            this.showImage();
            
        	}
        }
        return this;
    },
    
    showImage : function() {
    //	alert('before');
        var o = this.options;
        var args = this.queue[0];
        var index = args[0];
        var rewind = !!args[1];
        if (o.carousel && this.carousel && o.carousel_follow) {
            this.carousel.follow(index);
        }
        var src = this.getData(index).image;
        // === this.data[index]['image'] : webRoot + path image
        callMailToFriend = this.data[index]['image'];
        var active = this.controls.getActive();
        var next = this.controls.getNext();
        var cached = next.isCached(src);
        var complete = this.proxy(function() {
            this.queue.stalled = false;
            if(aConf.showPhotoDesc == true){
                this.data[index].dis = this.data[index].dis || '';
            	$('.galleria-image-info-center').html(this.data[index].dis);
            } else {
            	$('.galleria-image-info-center').html('');
            }
           $('.btnZoom').attr('target',index);
           $('#link-network').attr('shareimg',src);
           $('#link-network').attr('shareOrgImg',this.data[index].imageOrg);
           
           
            /// TODO BUG
            /// end set desc image
            this.toggleQuality(next.image, o.image_quality);
            this.setStyle( active.elem, { zIndex : 0 } );
            this.setStyle( next.elem, { zIndex : 1 } );

            this.trigger({
                type: G.IMAGE,
                index: index,
                imageTarget: next.image,
                thumbTarget: this.thumbnails[index].image
            });
            if (o.image_pan) {
                this.addPan(next.image);
            }
            this.controls.swap();
            this.moveOut( active.image );

            if (this.getData( index ).link) {
                this.setStyle( next.image, { cursor: 'pointer' } );
                
                this.listen( next.image, 'click', this.proxy(function() {
                    if (o.popup_links) {
                        var win = window.open(this.getData( index ).link, '_blank');
                    } else {
                        window.location.href = this.getData( index ).link;
                    }
                }));
            }
            Array.prototype.shift.call( this.queue );
            if (this.queue.length) {
                this.showImage();
            }
            this.playCheck();
        });
        if (typeof o.preload == 'number' && o.preload > 0) {
            var p,n = this.getNext();
            try {
                for (var i = o.preload; i>0; i--) {
                    p = new Picture();
                    p.add(this.getData(n).image);
                    n = this.getNext(n);
                }
            } catch(e) {}
        }
        this.trigger( {
            type: G.LOADSTART,
            cached: cached,
            index: index,
            imageTarget: next.image,
            thumbTarget: this.thumbnails[index].image
        } );
        jQuery(this.thumbnails[index].elem).addClass('active').siblings('.active').removeClass('active');
        
        next.load( src, this.proxy(function(e) {
            next.scale({
                width: this.stageWidth, 
                height: this.stageHeight, 
                crop: o.image_crop, 
                viewOrg: o.image_original,/// opt view image original
                max: o.max_scale_ratio, 
                min: o.min_scale_ratio,
                margin: o.image_margin,
                position: o.image_position,
                complete: this.proxy(function() {
                    if (active.image) {
                        this.toggleQuality(active.image, false);
                    }
                    this.toggleQuality(next.image, false);
                    this.trigger({
                        type: G.LOADFINISH,
                        cached: cached,
                        index: index,
                        imageTarget: next.image,
                        thumbTarget: this.thumbnails[index].image
                    });
                    this.queue.stalled = true;
                    var transition = G.transitions[o.transition] || o.transition;
                    this.removePan();
                    this.setInfo(index);
                    this.setCounter(index);
                    if (typeof transition == 'function') {
                        transition.call(this, {
                            prev: active.image,
                            next: next.image,
                            rewind: rewind,
                            speed: o.transition_speed || 400
                        }, complete );
                    } else {
                        complete();
                    }
                })
            });
        }));
    },
    
    getNext : function(base) {
        base = typeof base == 'number' ? base : this.active;
        return base == this.data.length - 1 ? 0 : base + 1;
    },
    
    getPrev : function(base) {
        base = typeof base == 'number' ? base : this.active;
        return base === 0 ? this.data.length - 1 : base - 1;
    },
    
    next : function() {
        if (this.data.length > 1) {
            this.show(this.getNext(), false);
        }
        return this;
    },
    
    prev : function() {
        if (this.data.length > 1) {
            this.show(this.getPrev(), true);
        }
        return this;
    },
    
    get : function( elem ) {
        return elem in this.dom ? this.dom[ elem ] : null;
    },
    
    getData : function( index ) {
        return this.data[index] || this.data[this.active];
    },
    
    getIndex : function() {
        return typeof this.active === 'number' ? this.active : 0;
    },
    
    play : function(delay) {
        this.trigger( G.PLAY );
        this.playing = true;
        this.playtime = delay || this.playtime;
        this.playCheck();
        return this;
    },
    
    pause : function() {
        this.trigger( G.PAUSE );
        this.playing = false;
        return this;
    },
    
    playCheck : function() {
        var p = 0;
        var i = 20; // the interval
        var ts = function() {
            return new Date().getTime();
        }
        var now = ts();
        if (this.playing) {
            this.clearTimer('play');
            var fn = this.proxy(function() {
                p = ts() - now;
                if ( p >= this.playtime && this.playing ) {
                    this.clearTimer('play');
                    this.next();
                    return;
                }
                if ( this.playing ) {
                    this.trigger({
                        type: G.PROGRESS,
                        percent: Math.ceil(p / this.playtime * 100),
                        seconds: Math.floor(p/1000),
                        milliseconds: p
                    });
                    this.addTimer('play', fn, i);
                }
            });
            this.addTimer('play', fn, i);
        }
    },
    
    setActive: function(val) {
        this.active = val;
        return this;
    },
    
    setCounter: function(index) {
        index = index || this.active;
        this.current.innerHTML = index+1;
        return this;
    },
    
    setInfo : function(index) {
        var data = this.getData(index || this.active);
        this.loop(['title','description','author'], function(type) {
            var elem = this.get('info-'+type);
            var fn = data[type] && data[type].length ? 'reveal' : 'hide';
            this[fn](elem);
            if (data[type]) {
                elem.innerHTML = data[type];
            }
        });
        return this;
    },
    
    hasInfo : function(index) {
        var d = this.getData(index);
        var check = 'title description author'.split(' ');
        for ( var i=0; check[i]; i++ ) {
            if ( d[ check[i] ] && d[ check[i] ].length ) {
                return true;
            }
        }
        return false;
    },
    
    getDataObject : function(o) {
        var obj = {
            image: '',
            thumb: '',
            title: '',
            description: '',
            author: '',
            link: ''
        };
        return o ? this.mix(obj,o) : obj;
    },
    
    jQuery : function( str ) {
        var ret = [];
        this.loop(str.split(','), this.proxy(function(elem) {
            elem = elem.replace(/^\s\s*/, "").replace(/\s\s*$/, "");
            if (this.get(elem)) {
                ret.push(elem);
            }
        }));
        var jQ = jQuery(this.get(ret.shift()));
        this.loop(ret, this.proxy(function(elem) {
            jQ = jQ.add(this.get(elem));
        }));
        return jQ;
    },
    
    $ : function( str ) {
        return this.jQuery( str );
    },
    
    toggleQuality : function(img, force) {
        if (!G.IE7 || typeof img == 'undefined' || !img) {
            return this;
        }
        if (typeof force === 'undefined') {
            force = img.style.msInterpolationMode == 'nearest-neighbor';
        }
        img.style.msInterpolationMode = force ? 'bicubic' : 'nearest-neighbor';

        return this;
    },
    
    unload : function() {
        //TODO
    },
	galleryLoad : function() {
		var loaded = 0;
		var o = this.options;
		if ((o.data_type == 'auto'
				&& typeof o.gallery_source == 'object'
				&& !(o.gallery_source instanceof jQuery) && !o.gallery_source.tagName)
				|| o.data_type == 'json'
				|| o.gallery_source.constructor == Array) {
			this.galleryData = o.gallery_source;
			this.currentDatas = o.currentDatas;
			// this.trigger( G.DATA );
		} else {
			alert('case else galleryLoad')
		}
	},
    load : function() {
        var loaded = 0;
        
        var o = this.options;
        if (
            (o.data_type == 'auto' && 
                typeof o.data_source == 'object' && 
                !(o.data_source instanceof jQuery) && 
                !o.data_source.tagName
            ) || o.data_type == 'json' || o.data_source.constructor == Array ) {
            this.data = o.data_source;
            this.trigger( G.DATA );
        } else { // assume selector
        	var images = jQuery(o.data_source).find(o.data_image_selector);
            var getData = this.proxy(function( elem ) {
                var i,j,anchor = elem.parentNode;
                if (anchor && anchor.nodeName == 'A') {
                    if (anchor.href.match(/\.(png|gif|jpg|jpeg)/i)) {
                        i = anchor.href;
                    } else {
                        j = anchor.href;
                    }
                }
                var obj = this.getDataObject({
                    title: elem.title,
                    thumb: elem.src,
                    image: i || elem.src,
                    description: elem.alt,
                    link: j || elem.getAttribute('longdesc'),
                    elem: elem
                });
                return this.mix(obj, o.data_config( elem ) );
            });
            this.loop(images, function( elem ) {
                loaded++;
                this.push( getData( elem ), this.data );
                if (!o.keep_source && !Galleria.IE) {
                    elem.parentNode.removeChild(elem);
                }
                if ( loaded == images.length ) {
                    this.trigger( G.DATA );
                }
            });
        } 
    }
});

G.log = function() {
    try { 
        console.log.apply( console, Array.prototype.slice.call(arguments) ); 
    } catch(e) {
        try {
            opera.postError.apply( opera, arguments ); 
        } catch(er) { 
              alert( Array.prototype.join.call( arguments, " " ) ); 
        } 
    }
};

var nav = navigator.userAgent.toLowerCase();
var hash = window.location.hash.replace(/#\//,'');

G.DATA = 'data';
G.READY = 'ready';
G.THUMBNAIL = 'thumbnail';
G.THUMBNAILALBUM = 'album-thumbnail';
G.LOADSTART = 'loadstart';
G.LOADFINISH = 'loadfinish';
G.IMAGE = 'image';
G.THEMELOAD = 'themeload';
G.PLAY = 'play';
G.PAUSE = 'pause';
G.PROGRESS = 'progress';
G.FULLSCREEN_ENTER = 'fullscreen_enter';
G.FULLSCREEN_EXIT = 'fullscreen_exit';
G.IDLE_ENTER = 'idle_enter';
G.IDLE_EXIT = 'idle_exit';
G.RESCALE = 'rescale';
G.LIGHTBOX_OPEN = 'lightbox_open';
G.LIGHTBOX_CLOSE = 'lightbox_cloe';
G.LIGHTBOX_IMAGE = 'lightbox_image';

G.IE8 = (typeof(XDomainRequest) !== 'undefined')
G.IE7 = !!(window.XMLHttpRequest && document.expando);
G.IE6 = (!window.XMLHttpRequest);
G.IE = !!(G.IE6 || G.IE7);
G.WEBKIT = /webkit/.test( nav );
G.SAFARI = /safari/.test( nav );
G.CHROME = /chrome/.test( nav );
G.QUIRK = (G.IE && document.compatMode && document.compatMode == "BackCompat");
G.MAC = /mac/.test(navigator.platform.toLowerCase());
G.OPERA = !!window.opera

G.Picture = Picture;

G.addTheme = function(obj) {
    var theme = {};
    var orig = ['name','author','version','defaults','init'];
    var proto = G.prototype;
    proto.loop(orig, function(val) {
        if (!obj[ val ]) {
            G.raise(val+' not specified in theme.');
        }
        if (val != 'name' && val != 'init') {
            theme[val] = obj[val];
        }
    });
    theme.init = obj.init;
    
    if (obj.css) {
        var css;
        proto.loop(proto.getElements('script'), function(el) {
            var reg = new RegExp('galleria.' + obj.name.toLowerCase() + '.js');
            if(reg.test(el.src)) {
                css = el.src.replace(/[^\/]*$/, "") + obj.css;
                proto.loadCSS(css, function() {
                    G.theme = theme;
                    jQuery(document).trigger( G.THEMELOAD );
                });
            }
        });
        if (!css) {
            G.raise('No theme CSS loaded');
        }
    }
    return theme;
};

G.raise = function(msg) {
    if ( G.debug ) {
        throw new Error( msg );
    }
};

G.loadTheme = function(src) {
    G.prototype.loadScript(src);
};

G.galleries = [];
G.get = function(index) {
    if (G.galleries[index]) {
        return G.galleries[index];
    } else if (typeof index !== 'number') {
        return G.galleries;
    } else {
        G.raise('Gallery index not found');
    }
}

jQuery.easing.galleria = function (x, t, b, c, d) {
    if ((t/=d/2) < 1) { 
        return c/2*t*t*t*t + b;
    }
    return -c/2 * ((t-=2)*t*t*t - 2) + b;
};

G.transitions = {
    add: function(name, fn) {
        if (name != arguments.callee.name ) {
            this[name] = fn;
        }
    },
    fade: function(params, complete) {
        jQuery(params.next).show().css('opacity',0).animate({
            opacity: 1
        }, params.speed, complete);
        if (params.prev) {
            jQuery(params.prev).css('opacity',1).animate({
                opacity: 0
            }, params.speed);
        }
    },
    flash: function(params, complete) {
        jQuery(params.next).css('opacity',0);
        if (params.prev) {
            jQuery(params.prev).animate({
                opacity: 0
            }, (params.speed/2), function() {
                jQuery(params.next).animate({
                    opacity: 1
                }, params.speed, complete);
            });
        } else {
            jQuery(params.next).animate({
                opacity: 1
            }, params.speed, complete);
        }
    },
    pulse: function(params, complete) {
        if (params.prev) {
            jQuery(params.prev).css('opacity',0);
        }
        jQuery(params.next).css('opacity',0).animate({
            opacity:1
        }, params.speed, complete);
    },
    slide: function(params, complete) {
        var image = jQuery(params.next).parent();
        var images =  this.$('images');
        var width = this.stageWidth;
        image.css({
            left: width * ( params.rewind ? -1 : 1 )
        });
        images.animate({
            left: width * ( params.rewind ? 1 : -1 )
        }, {
            duration: params.speed,
            queue: false,
            easing: 'galleria',
            complete: function() {
                images.css('left',0);
                image.css('left',0);
                complete();
            }
        });
    },
    fadeslide: function(params, complete) {
        if (params.prev) {
            jQuery(params.prev).css({
                opacity: 1,
                left: 0
            }).animate({
                opacity: 0,
                left: 50 * ( params.rewind ? 1 : -1 )
            },{
                duration: params.speed,
                queue: false,
                easing: 'swing'
            });
        }
        jQuery(params.next).css({
            left: 50 * ( params.rewind ? -1 : 1 ), 
            opacity: 0
        }).animate({
            opacity: 1,
            left:0
        }, {
            duration: params.speed,
            complete: complete,
            queue: false,
            easing: 'swing'
        });
    }
};

G.addTransition = function() {
    G.transitions.add.apply(this, arguments);
}

jQuery.fn.galleria = function(options) {
    options = options || {};
    var selector = this.selector;
    
    return this.each(function() {
        if ( !options.keep_source ) {
        //    jQuery(this).children().hide();
        }
    
        options = G.prototype.mix(options, {target: this} );
        var height = G.prototype.height(this) || G.prototype.getStyle(this, 'height', true);
        if (!options.height && height) {
            options = G.prototype.mix( { height: height }, options );
        }
    
        G.debug = !!options.debug;
    
        var gallery = new G(options);
        
        Galleria.galleries.push(gallery);
    
        if (G.theme) {
            gallery.init();
        } else {
            jQuery(document).bind(G.THEMELOAD, function() {
                gallery.init();
            });
        }
    })
};


})();
function print_r(obj, space) {

	return loopDump(obj, space)

}
function loopDump(obj, space) {
	space = space ? space : '\n';
	space2 = (space == '<br>') ? '&nbsp;&nbsp;&nbsp;&nbsp;' : '    '
	var key = '';
	var keys = '';

	for (key in obj) {
		if (typeof (obj[key]) == 'object') {
			keys += space + loopDump(obj[key], space)
		} else {
			keys += '[' + key + ']=' + obj[key] + space;
		}
	}
	return keys;
}
function buildSliderZoom() {
	
	//CASE DEFAULT ZOOM LEVEL
	$('.galleria-album-stage-image').find('.galleria-image').each(function(){
		var width = (aConf.sizeThumb * aSize[aConf.zoomLevel]) / 100;
		opsitionImage = width;
		var height = (aConf.sizeThumb * aSize[aConf.zoomLevel]) / 100;
		
		$(this).width(width).height(height).find('img').each(function(){
			if ($(this).attr('folder')) {
				$(this).width(width-20).height(height-20);
			}else {
				$(this).width(width).height(height);
			}
		})
	})
	
	$('#slider').hide().html('').slider({
		min: 1,
		max: 7,
		range: "min",
		value: aConf.zoomLevel,
		change: function(event, ui) {
			$('.galleria-album-stage-image').find('.galleria-image').each(function(){
				var width = (aConf.sizeThumb * aSize[ui.value]) / 100;
				opsitionImage = width;
				var height = (aConf.sizeThumb * aSize[ui.value]) / 100;
				$(this).width(width).height(height).find('img').each(function(){
					if ($(this).attr('folder')) {
						$(this).width(width-20).height(height-20);
					} else {
						$(this).width(width).height(height);
					}
				})
			})
		}
	}).each(function(){
		$(this).show();
	});
}

function loadingActive(status,isNotMsg) {
	
	obj = (rvActiveFulls =='full')
			? $('.galleria-container')
			: $('#galleria');
	if(status == 'show' && !$('#loading').get(0)){
		textMsg = (isNotMsg)?'': txtLoading
		span = jQuery('<span/>').text(txtLoading).css({
			'background':'#FFFFFF',
			'position':'absolute',
			'z-index':'10000000'
		}).attr({
			'id':'loading'
		});
		obj.prepend(span.prepend(jQuery('<img/>').attr({
					'src':SGL_JS_WEBROOT+'/js/photogallery/themes/rvsdefault/images/loading02.gif',
					'align':'middle'
					}
					)));
		setTimeout(function(){
			span.css({
				'left': span.offset().left+(obj.width()/2 ) - (span.width()/2 ),
				'top': span.offset().top+(obj.height()/2 ) - (span.height()/2 )
			});
			
		},10);
	}else{
		span.remove();
		$('#loading').remove();

	}
}
/// start fn : pager
// onload initPagination();
function pageselectCallback(page_index, jq){
    var num_entries = jQuery('div.displaynone').length;
    var max_elem = Math.min((page_index+1) * aConf.thumbPerPage, num_entries);
	pageNo = page_index;
	if(pageNo != 0 ) {
		pageNo = pageNo * aConf.thumbPerPage;
	}
    shownum = 0;
    dataShow = 0; ///  เพื่อนับจำนวนที่ต้องการ ถ้าได้แล้วก็ไม่ต้องทำอีก ลดจำนวนลูป
    $('.displaynone').hide().each(function(){
    	if(dataShow == aConf.thumbPerPage) return false;
		if(shownum >= pageNo && shownum < max_elem ){
			jQuery(this).show();
			dataShow++;
		}
		shownum++;
	});
    return false;
}
function initPagination(numData) {
    // count entries inside the hidden content
    var num_entries = numData;
    if(num_entries < aConf.thumbPerPage) {
    	$("#Pagination").html('');
    	return false;
    }
    $("#Pagination").pagination(num_entries, {
        callback: pageselectCallback,
        items_per_page: aConf.thumbPerPage, // Show only one item per page
        num_display_entries: 5,
		num_edge_entries: 2,
		prev_text: txtPrev,
		next_text: txtNext
    });
 }
/// end fn : pager

function loadGalleria(setUrlAjax, resending){
	loadingActive('show');
	setUrlAjax = setUrlAjax || '';
	var rvsBuildin =  new Galleria.RvsBuildin(galleryId, {
		'serviceFile' : urlAjax + setUrlAjax
		});
	if(resending) {
		resend = true;
	}else{
		resend = false;
	}

		setTimeout(function(){  
			loadingActive('hide');
		rvsBuildin.getAlbum(null, function(data) {
			jQuery('#galleria').galleria({
			callrun: 'rvsrun',
			gallery_source:rvsBuildin.galleryDatas,
			folder_source:rvsBuildin.folderDatas,
			currentDatas:rvsBuildin.currentDatas,
			data_source:data,
			thumb_crop: 'height',
			image_pan: true,// จะเลื่อนได้ถ้ารูปโดน crop
			image_crop: aConf.viewImgFitSize,// แสดงแบบภาพโดนตัด จะตัด H หรือ w ดูที่ thumb_crop : ถ้าตั้ง true image_ori ต้องเป็น false
			image_original: aConf.viewImgOri,// show image original
			ctrl_autoplay: aConf.autoPlay,
			conf_fb: aConf.fb,
			conf_tw: aConf.tw,
			conf_sp: aConf.sp,
			conf_mail: aConf.mail,
			resend: resend,
			transition_speed: (parseFloat(aConf.transitionSpeed) * 1000),
			extend : function(){
				$('#galleria').height($('#galleria').height());
				var gallery = this;
	            if(aConf.autoPlay == true) gallery.pause();
	           // Start  if check view image Full Size
	            if((aConf.viewImageFullSize === true || aConf.viewImageFullSize === 'true') && (aConf.viewImageFullSize != undefined)) {
	            	this.bind(Galleria.IMAGE,function(e) {
						$(e.imageTarget).css('cursor','pointer').click(this.proxy(function(){
							if (gallery.options.callrun == 'rvsrun') {
								targetIndex = e.index;
								if(gallery.data[targetIndex]['imageOrg'].match(/http/gi)) {
									path = gallery.data[targetIndex]['imageOrg'];
									path2 = gallery.data[targetIndex]['image'];
								} else {
									path = rvsWebRoot +'/'+ gallery.data[targetIndex]['imageOrg'];
									path2 = rvsWebRoot +'/'+ gallery.data[targetIndex]['image'];
								}
								var imageThem = new Image();
								imageThem.src = path;
								var imageThem2 = new Image();
								imageThem2.src = path2;
								
								if (imageThem.complete){
									window.open(path, 'popup'+targetIndex, "width="+imageThem.width+",height="+imageThem.height+",status=0,toolbar=0,menubar=0,location=0,scrollbars=1");							
								} else {
									window.open(path2, 'popup'+targetIndex, "width="+imageThem2.width+",height="+imageThem2.height+",status=0,toolbar=0,menubar=0,location=0,scrollbars=1");							
								}
							} else {
									this.openLightbox();
							}
						}));
					});
	            }//End if check view image Full Size
			} 
			});
		});

		},2000);
}
/// start ไว้จับเวลา รอลบ
var ms = 0;
var state = 0;
function startstop() {
	if (state == 0) {
		state = 1;
		then = new Date();
		then.setTime(then.getTime() - ms);
	} else {
		state = 0;
		now = new Date();
		ms = now.getTime() - then.getTime();
        ms = time(ms);
		document.stpw.time.value =ms;
   }
}
function swreset() {
	state = 0;	ms = 0; document.stpw.time.value = ms;
}
function display() {
	setTimeout("display();", 50);
	if (state == 1)  {
		now = new Date();
		ms = now.getTime() - then.getTime();
		 ms = time(ms);
		document.stpw.time.value = ms;
   }
}
function time(ms) {
	var sec = Math.floor(ms/1000)
	ms = ms % 1000
	t = ms
	var min = Math.floor(sec/60)
	sec = sec % 60
	t = sec + ":" + t
	var hr = Math.floor(min/60)
	min = min % 60
	t = min + ":" + t
	return t
	}
/// endไว้จับเวลา

/*!
 * Galleria SlideShowPro Plugin v 1.1
 * http://galleria.aino.se
 *
 * Copyright 2010, Aino
 * Licensed under the MIT license.
 */



(function($) {

	var G = window.Galleria; 
	if (typeof G == 'undefined') {
		return;
	}
		G.RvsBuildin = {};
	var F = G.RvsBuildin = function(galleryId, options) {
		if (!galleryId) {
	        G.raise('No galleryId found');
	    }
		
		this.galleryId = galleryId;
		this.callback = function(){};
		
		_aDomain = this.parseUri(window.location.href);
		this.domain = _aDomain.protocol + '://' +  _aDomain.host;
		if (_aDomain.port != 'undefined' && _aDomain.port != '') {
			this.domain = this.domain + ':' + _aDomain.port;
		}
		this.domain = this.domain + _aDomain.directory;

		this.options = {
				max: 40,
				size: 'big',
				sort: 'interestingness-desc',
				debug: false
		}
		for (k in options) {
			switch (k) {
			case 'serviceFile': 
				this.serviceFile = options[k];
				break;
			case 'builG': 
				this.builG = options[k];
				break;
			}
		}
		if(this.builG){/// check ว่า เป็นปุ่มต่างๆ ไม่ต้องให้เข้า buil gallery
				this.getGallery();
		}
		
	};

	F.prototype = {
			serviceFile: 'rvPhotoGalleria/service.php?',
			serviceUrl: null,
			galleryId: null,
			builG: true,
			domain: '',
			galleryDatas: {},
			folderDatas: {},
			currentDatas: {},
			setGalleryDatas: function(datas) {
				this.galleryDatas = datas;
			},

			setGallery: function(data) {
				this.currentDatas = data['currentDatas'];
				this.galleryDatas = [];
				if (data['datas'] != undefined) {
					i=0;
					for(k in data['datas']) {
						this.galleryDatas[i] = {
 								'album_name':webRoot + '/' + data['datas'][k]['title'],
								'album_id': data['datas'][k]['albumId'],
								'thumb': webRoot + '/' + data['datas'][k]['thumb'],
								'title': data['datas'][k]['title'],
								'default_focus': data['datas'][k]['default_focus']
						};
						if(data['datas'][k]['albumId'] == this.currentDatas.albumId){
							this.currentDatas.albumName = data['datas'][k]['title'];
							this.currentDatas.albumDesc =data['datas'][k]['dis'];
						}
						i++;
					}
				}
			},
			
			getGallery: function() {
				this._set(arguments);
				return this._find(
					{
						gallery_id: this.galleryId,
						rvsAct:'viewGallery'
					},
					function (data) {
						this.setGallery(data); 
				});
			},
			/// start rvs social network
			shareNetwork: function(optSocial) {
				this._set(arguments);
				return this._find(
					{
						gallery_id: this.galleryId,
						pathImg : optSocial.optPath,//img,
						rvsAct: 'writeImg'
					},
					function (data) {
						if (optSocial.optMode == 'im') {
							u = optSocial.optPath;
						} else {
							u = webRoot+'/'+webIndex+'/photogallery/Fb/action/vpg/mo/'+optSocial.optMode+'/img/p'+data.imgIndex;
						}
						/*u = webRoot+'/'+webIndex+'/photogallery/Fb/action/vpg/mo/'+optSocial.optMode+'/img/p'+data.imgIndex;*/
						t = document.title;
						if (optSocial.optType == 'fb') {
							window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');
						} else if(optSocial.optType=='tw'){
							window.open('http://twitter.com/share?url='+encodeURIComponent(u)+'&title='+encodeURIComponent(t)+'&via=en','sharer','toolbar=0,status=0,width=626,height=436');
						} else if(optSocial.optType == 'sp'){
							window.open('http://www.myspace.com/Modules/PostTo/Pages/?u=='+encodeURIComponent(u),'ptm','toolbar=0,status=0,width=626,height=436');
						}
				});
			},
			/// end rvs social network
			getDefaultAlbumId: function() {
				for (k in this.galleryDatas) {
					if (this.galleryDatas[k]['default_focus'] != undefined && this.galleryDatas[k]['default_focus'] == true)
						return k;
				}
				return null;
			},
			
			getAlbum: function(album_id, callback) {
				this._set(arguments);
				return this._find({
						album_id: album_id,
						rvsAct:'viewAlbum'
					}, function (data) {
						this.setAlbum(data);
				});
			},
			
			setAlbum: function(data) {
				this.albumDatas = {};
				if (data['image'] != undefined) {
					var obj = { length: 0 };
					///TODO TEST
					var item = {
							'item_id' : [],
							'type' : [],
							'thumb' : [],
							'image' : [],
							'dis' : [],
							'nameimg' : [],
							'title' : [],
							'imageOrg' : []
					};
					this.folderDatas = {
							'item_id' : [],
							'type' : [],
							'thumb' : [],
							'image' : [],
							'dis' : [],
							'title' : []
					};
					i = 0;
					aData = [];
					count = 0;
					/// list image :: data['image']
					for(k in data['image']) {				
						aData = {
								'type' : 'p', // a|p|g  a = album, p = photo, g = gallery
								'title' : data['image'][k]['desc'],
								'dis' : data['image'][k]['desc'],
								'nameimg' : data['image'][k]['nameImg'],
								'image' : webRoot + '/'+data['request']['pathPhoto'] + '/'+data['image'][k]['name'],
								'thumb' : webRoot + '/'+data['request']['pathPhoto'] + '/thumbs/'+data['image'][k]['name'],
								'imageOrg' : webRoot + '/'+data['request']['pathPhoto'] + '/images_org/' + data['image'][k]['name']
							}
						count++;
						
					//$('#debug').html(print_r(aData,'<br>'))
						Array.prototype.push.call(obj, aData);
					}
					i=0;
					/// list folder :: data['folder']
					this.folderDatas = [];
					if (data['folder'] != undefined) {
					for(k in data['folder']) {	
						this.folderDatas[i]= {};
						typeDatas = data['folder'][k]['type'] || 'f';
						this.folderDatas[i].type = typeDatas, // f|uf|  f=folder, uf=up one folder
						this.folderDatas[i].title =  data['folder'][k]['desc'];
						this.folderDatas[i].dis =data['folder'][k]['desc'];
						this.folderDatas[i].path =data['folder'][k]['path'];
						this.folderDatas[i].image =  webRoot + '/' + data['folder'][k]['name'];
						this.folderDatas[i].thumb = webRoot + '/' + data['folder'][k]['name'];
						i++;
					}
				}
					
				}else{
					var obj = { length: 0 };
					///TODO TEST
					var item = {
							'item_id' : [],
							'type' : [],
							'thumb' : [],
							'image' : [],
							'dis' : [],
							'title' : []
					};
					Array.prototype.push.call(obj,item);
				}

				this.callback.call(this, obj);
			},
			
			showDebug: function(msg) {
				if(this.debug && window.console) {
                    if(!document.all) {
                    	console.debug('Debug: ' + msg);
                    }
                }
			},
			
			setOptions: function(options) {
				jQuery.extend(this.options, options);
				return this;
			},
			
			_set: function(args) {
				args = Array.prototype.slice.call(args);
				this.callback = args[2] || args[1];
				if (typeof args[1] == 'object') {
					this.setOptions(args[1]);
				}
				return this;
			},
			
			_call: function(params, callback) {
				//var url = this.domain + this.serviceFile;
			//alert(this.serviceFile);
				var url = this.serviceFile;
                 var scope = this;
				params = jQuery.extend({
					format : 'json',
				//	jsoncallback : '?',
					gallery_id: this.galleryId
				//	rvsMgr:'photogallery',
				//	rvsAct:'viewPhotoGallery'	
				}, params);
			
				jQuery.each(params, function(key, value) {
					url += '&'+ key + '=' +value;
				});
				jQuery.getJSON(url, function(data) {
					if (data.stat == 'ok') {
				//this.showDebug('Get '+ url + ' return status ' + data.stat);
						callback.call(scope, data);
					} else {
						this.showDebug(data.stat + ' '+data.code.toString() + ' ' +  ': ' + data.message);
						G.raise(data.stat + ' '+data.code.toString() + ' ' +  ': ' + data.message);
					}
				});
			},
			
			_find: function(params, callback) {
				params = jQuery.extend({
					method: 'search',
				    sort: this.options.sort
				}, params);
				
				if (callback != undefined)
					return this._call(params, callback);
				else 
				return this._call(params, function(data) {
					var obj = { length: 0 };

					var photos = data.photos ? data.photos.photo : data.photoset.photo;
					var len = Math.min(this.options.max, photos.length);
					var loaded = 0;
				    
					for (var i=0; i<len; i++) {
		    		    var photo = photos[i],
		    		        img = photo.url_m;
		    		    switch(this.options.size) {
		    		        case 'small':
		    		            img = photo.url_s;
		    		            break;
		    		        case ( 'big' || 'large' ):
		    		            if (photo.url_l) {
		    		                img = photo.url_l;
		    		            } else if (parseInt(photo.width_o) > 1280) {
		    		                img = 'http://farm'+photo['farm']+'.static.flickr.com/'+photo['server']+
		    		                      '/'+photo['id']+'_' + photo['secret'] + '_b.jpg';
		                            
		    		            } else if(photo.url_o) {
		    		                img = photo.url_o;
		    		            }
		    		            break;
		    		        case 'original':
		    		            if(photo.url_o) {
		    		                img = photo.url_o;
		    		            }
		    		            break;    
		    		    }
		                var item = {
		    				thumb: photos[i].url_t,
		    				image: img,
		    				title: photos[i].title
		    			};
		    			Array.prototype.push.call(obj, item);
					}
					this.callback.call(this, obj);
				});
			},
			
			parseUri: function(str) {
				var	o   = {
						strictMode: false,
						key: ["source", "protocol", "authority", "userInfo", "user", "password", "host", "port", "relative", "path", "directory" ,"file", "query", "anchor"],
						q:   {
							name:   "queryKey",
							parser: /(?:^|&)([^&=]*)=?([^&]*)/g
						},
						parser: {
							strict: /^(?:([^:\/?#]+):)?(?:\/\/((?:(([^:@]*)(?::([^:@]*))?)?@)?([^:\/?#]*)(?::(\d*))?))?((((?:[^?#\/]*\/)*)([^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,
							loose:  /^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/)?((?:(([^:@]*)(?::([^:@]*))?)?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/
						}
					};
					m   = o.parser[o.strictMode ? "strict" : "loose"].exec(str),
					uri = {},
					i   = 14;

				while (i--) uri[o.key[i]] = m[i] || "";

				uri[o.q.name] = {};
				uri[o.key[12]].replace(o.q.parser, function ($0, $1, $2) {
					if ($1) uri[o.q.name][$1] = $2;
				});

				return uri;
			}
	};

	G.raise = function(msg) {
		alert(msg);
	};
	
	G.rvsrun = function()
	{
		alert('Call rvsrun');
		
	};
})(jQuery);

/**
 * This jQuery plugin displays pagination links inside the selected elements.
 * 
 * This plugin needs at least jQuery 1.4.2
 *
 * @author Gabriel Birke (birke *at* d-scribe *dot* de)
 * @version 2.2
 * @param {int} maxentries Number of entries to paginate
 * @param {Object} opts Several options (see README for documentation)
 * @return {Object} jQuery Object
 */
 (function($){
	/**
	 * @class Class for calculating pagination values
	 */
	$.PaginationCalculator = function(maxentries, opts) {
		this.maxentries = maxentries;
		this.opts = opts;
	}
	
	$.extend($.PaginationCalculator.prototype, {
		/**
		 * Calculate the maximum number of pages
		 * @method
		 * @returns {Number}
		 */
		numPages:function() {
			return Math.ceil(this.maxentries/this.opts.items_per_page);
		},
		/**
		 * Calculate start and end point of pagination links depending on 
		 * current_page and num_display_entries.
		 * @returns {Array}
		 */
		getInterval:function(current_page)  {
			var ne_half = Math.floor(this.opts.num_display_entries/2);
			var np = this.numPages();
			var upper_limit = np - this.opts.num_display_entries;
			var start = current_page > ne_half ? Math.max( Math.min(current_page - ne_half, upper_limit), 0 ) : 0;
			var end = current_page > ne_half?Math.min(current_page+ne_half + (this.opts.num_display_entries % 2), np):Math.min(this.opts.num_display_entries, np);
			return {start:start, end:end};
		}
	});
	
	// Initialize jQuery object container for pagination renderers
	$.PaginationRenderers = {}
	
	/**
	 * @class Default renderer for rendering pagination links
	 */
	$.PaginationRenderers.defaultRenderer = function(maxentries, opts) {
		this.maxentries = maxentries;
		this.opts = opts;
		this.pc = new $.PaginationCalculator(maxentries, opts);
	}
	$.extend($.PaginationRenderers.defaultRenderer.prototype, {
		/**
		 * Helper function for generating a single link (or a span tag if it's the current page)
		 * @param {Number} page_id The page id for the new item
		 * @param {Number} current_page 
		 * @param {Object} appendopts Options for the new item: text and classes
		 * @returns {jQuery} jQuery object containing the link
		 */
		createLink:function(page_id, current_page, appendopts){
			var lnk, np = this.pc.numPages();
			page_id = page_id<0?0:(page_id<np?page_id:np-1); // Normalize page id to sane value
			appendopts = $.extend({text:page_id+1, classes:""}, appendopts||{});
			if(page_id == current_page){
				lnk = $("<span class='current'>" + appendopts.text + "</span>");
			}
			else
			{
				lnk = $("<a>" + appendopts.text + "</a>")
					.attr('href', this.opts.link_to.replace(/__id__/,page_id));
			}
			if(appendopts.classes){ lnk.addClass(appendopts.classes); }
			lnk.data('page_id', page_id);
			return lnk;
		},
		// Generate a range of numeric links 
		appendRange:function(container, current_page, start, end, opts) {
			var i;
			for(i=start; i<end; i++) {
				this.createLink(i, current_page, opts).appendTo(container);
			}
		},
		getLinks:function(current_page, eventHandler) {
			var begin, end,
				interval = this.pc.getInterval(current_page),
				np = this.pc.numPages(),
				fragment = $("<div class='pagination'></div>");
			
			// Generate "Previous"-Link
			if(this.opts.prev_text && (current_page > 0 || this.opts.prev_show_always)){
				fragment.append(this.createLink(current_page-1, current_page, {text:this.opts.prev_text, classes:"prev"}));
			}
			// Generate starting points
			if (interval.start > 0 && this.opts.num_edge_entries > 0)
			{
				end = Math.min(this.opts.num_edge_entries, interval.start);
				this.appendRange(fragment, current_page, 0, end, {classes:'sp'});
				if(this.opts.num_edge_entries < interval.start && this.opts.ellipse_text)
				{
					jQuery("<span>"+this.opts.ellipse_text+"</span>").appendTo(fragment);
				}
			}
			// Generate interval links
			this.appendRange(fragment, current_page, interval.start, interval.end);
			// Generate ending points
			if (interval.end < np && this.opts.num_edge_entries > 0)
			{
				if(np-this.opts.num_edge_entries > interval.end && this.opts.ellipse_text)
				{
					jQuery("<span>"+this.opts.ellipse_text+"</span>").appendTo(fragment);
				}
				begin = Math.max(np-this.opts.num_edge_entries, interval.end);
				this.appendRange(fragment, current_page, begin, np, {classes:'ep'});
				
			}
			// Generate "Next"-Link
			if(this.opts.next_text && (current_page < np-1 || this.opts.next_show_always)){
				fragment.append(this.createLink(current_page+1, current_page, {text:this.opts.next_text, classes:"next"}));
			}
			$('a', fragment).click(eventHandler);
			return fragment;
		}
	});
	
	// Extend jQuery
	$.fn.pagination = function(maxentries, opts){
		
		// Initialize options with default values
		opts = jQuery.extend({
			items_per_page:10,
			num_display_entries:11,
			current_page:0,
			num_edge_entries:0,
			link_to:"#",
			prev_text:"Prev",
			next_text:"Next",
			ellipse_text:"...",
			prev_show_always:true,
			next_show_always:true,
			renderer:"defaultRenderer",
			load_first_page:false,
			step_sitebuilder:'2',
			callback:function(){return false;}
		},opts||{});
		
		var containers = this,
			renderer, links, current_page;
		
		/**
		 * This is the event handling function for the pagination links. 
		 * @param {int} page_id The new page number
		 */
		function paginationClickHandler(evt){
			var links, 
				new_current_page = $(evt.target).data('page_id'),
				continuePropagation = selectPage(new_current_page);
			if (!continuePropagation) {
				evt.stopPropagation();
			}
			return continuePropagation;
		}
		
		/**
		 * This is a utility function for the internal event handlers. 
		 * It sets the new current page on the pagination container objects, 
		 * generates a new HTMl fragment for the pagination links and calls
		 * the callback function.
		 */
		function selectPage(new_current_page) {
			// update the link display of a all containers
			containers.data('current_page', new_current_page);
			links = renderer.getLinks(new_current_page, paginationClickHandler);
			containers.empty();
			links.appendTo(containers);
			// call the callback and propagate the event if it does not return false
			var continuePropagation = opts.callback(new_current_page, containers);
			return continuePropagation;
		}
		
		function setTextDetailPager(allpager){
			jQuery('#pageAll').text(allpager);
		}
		
		// -----------------------------------
		// Initialize containers
		// -----------------------------------
		current_page = opts.current_page;
		containers.data('current_page', current_page);
		// Create a sane value for maxentries and items_per_page
		maxentries = (!maxentries || maxentries < 0)?1:maxentries;
		opts.items_per_page = (!opts.items_per_page || opts.items_per_page < 0)?1:opts.items_per_page;
		
		if(!$.PaginationRenderers[opts.renderer])
		{
			throw new ReferenceError("Pagination renderer '" + opts.renderer + "' was not found in jQuery.PaginationRenderers object.");
		}
		renderer = new $.PaginationRenderers[opts.renderer](maxentries, opts);
		
		// Attach control events to the DOM elements
		var pc = new $.PaginationCalculator(maxentries, opts);
		var np = pc.numPages();
		if(opts.step_sitebuilder == '2'){
			setTextDetailPager(np); //sitebuilder
		}
		containers.bind('setPage', {numPages:np}, function(evt, page_id) { 
				if(page_id >= 0 && page_id < evt.data.numPages) {
					selectPage(page_id); return false;
				}
		});
		containers.bind('prevPage', function(evt){
				var current_page = $(this).data('current_page');
				if (current_page > 0) {
					selectPage(current_page - 1);
				}
				return false;
		});
		containers.bind('nextPage', {numPages:np}, function(evt){
				var current_page = $(this).data('current_page');
				if(current_page < evt.data.numPages - 1) {
					selectPage(current_page + 1);
				}
				return false;
		});
		
		// When all initialisation is done, draw the links
		links = renderer.getLinks(current_page, paginationClickHandler);
		containers.empty();
		links.appendTo(containers);
		// call callback function
		if(opts.load_first_page) {
			opts.callback(current_page, containers);
		}
	} // End of $.fn.pagination block
	
})(jQuery);jQuery.url=function()
{var segments={};var parsed={};var options={url:window.location,strictMode:false,key:["source","protocol","authority","userInfo","user","password","host","port","relative","path","directory","file","query","anchor"],q:{name:"queryKey",parser:/(?:^|&)([^&=]*)=?([^&]*)/g},parser:{strict:/^(?:([^:\/?#]+):)?(?:\/\/((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?))?((((?:[^?#\/]*\/)*)([^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,loose:/^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/)?((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/}};var parseUri=function()
{str=decodeURI(options.url);var m=options.parser[options.strictMode?"strict":"loose"].exec(str);var uri={};var i=14;while(i--){uri[options.key[i]]=m[i]||"";}
uri[options.q.name]={};uri[options.key[12]].replace(options.q.parser,function($0,$1,$2){if($1){uri[options.q.name][$1]=$2;}});return uri;};var key=function(key)
{if(!parsed.length)
{setUp();}
if(key=="base")
{if(parsed.port!==null&&parsed.port!=="")
{return parsed.protocol+"://"+parsed.host+":"+parsed.port+"/";}
else
{return parsed.protocol+"://"+parsed.host+"/";}}
return(parsed[key]==="")?null:parsed[key];};var param=function(item)
{if(!parsed.length)
{setUp();}
return(parsed.queryKey[item]===null)?null:parsed.queryKey[item];};var setUp=function()
{parsed=parseUri();getSegments();};var getSegments=function()
{var p=parsed.path;segments=[];segments=parsed.path.length==1?{}:(p.charAt(p.length- 1)=="/"?p.substring(1,p.length- 1):path=p.substring(1)).split("/");};return{setMode:function(mode)
{strictMode=mode=="strict"?true:false;return this;},setUrl:function(newUri)
{options.url=newUri===undefined?window.location:newUri;setUp();return this;},segment:function(pos)
{if(!parsed.length)
{setUp();}
if(pos===undefined)
{return segments.length;}
return(segments[pos]===""||segments[pos]===undefined)?null:segments[pos];},attr:key,param:param};}();
