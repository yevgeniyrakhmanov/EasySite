// $Id: bueditor.js,v 1.18.2.1 2007/12/20 18:13:29 ufku Exp $

// initiate editor variable that will hold other variables and fuctions.
var editor = {instances: [], buttons: [], popups: [], path: '', dialog: {}, bpr: 20, //# of buttons per row.
  mode: (window.getSelection || document.getSelection) ? 1 : ( document.selection && document.selection.createRange ? 2 : 0 )
}

//process textareas that have "editor-textarea" class.
editor.initiate = function () {
  var i, T, Ts = document.getElementsByTagName('textarea');
  for (i=0; T=Ts[i]; i++) {
    if (editor.hasClass(T, 'editor-textarea')) {
      editor.processTextarea(T);
    }
  }
}

//create an editor instance
editor.instance = function (T, index) {
  this.index = index;
  this.textArea = T;
  this.textArea.editor = this;
  this.buttons = document.getElementById('editor-'+index).getElementsByTagName('input');
  this.bindex = null;//latest clicked button index
  this.focus = function () {
    this.textArea.focus();
  }
  this.getContent = function () {
    return editor.processText(this.textArea.value);
  }
  this.setContent = function (content) {
    var st = this.textArea.scrollTop;
    this.textArea.value = content;
    this.textArea.scrollTop = st;
  }
  this.getSelection = function () {
    var pos = this.posSelection();
    return this.getContent().substring(pos.start, pos.end);
  }
  this.replaceSelection = function (txt, cursor) {
    var txt = editor.processText(txt);
    var pos = this.posSelection();
    var content = this.getContent();
    this.setContent(content.substr(0, pos.start) + txt + content.substr(pos.end));
    var end = cursor == 'start' ? pos.start : pos.start+txt.length;
    var start = cursor == 'end' ? end : pos.start;
    this.makeSelection(start, end);
  }
  this.tagSelection = function (left, right, cursor) {
    var left = editor.processText(left);
    var right = editor.processText(right);
    var llen = left.length;
    var pos = this.posSelection();
    var content = this.getContent();
    this.setContent(content.substr(0, pos.start) + left + content.substring(pos.start, pos.end) + right + content.substr(pos.end));
    var end = cursor=='start' ? pos.start+llen : pos.end+llen;
    var start = cursor=='end' ? end : pos.start+llen;
    this.makeSelection(start, end);
  }
  this.makeSelection = function (start, end) {
    if (end<start) end = start;
    editor.selMake(this.textArea, start, end);
    if (editor.dialog.esp) editor.dialog.esp = {start: start, end: end};
  }
  this.posSelection = function () {
    return editor.dialog.esp ? editor.dialog.esp : editor.selPos(this.textArea);
  }
  this.buttonsDisabled = function (state, bindex) {
    for (var i=0; b=this.buttons[i]; i++) {
      b.disabled = i==bindex ? !state : state;
    }
  }
  this.accesskeys = function (state) {
    for (var i=0; b=this.buttons[i]; i++) {
      b.accessKey = state ? editor.buttons[i][3] : '';
    }
  }
}

//execute button's click event
editor.buttonClick = function (eindex, bindex) {
  try {
    var E = editor.active = editor.instances[eindex];
    E.bindex = bindex;
    var b = editor.buttons[bindex];
    var content = b[1];
    editor.dialog.close();
    if (b[4]) b[4](E); //execute button script.
    else if (content) {
      var arr = content.split('%TEXT%');
      if (arr.length==2) E.tagSelection(arr[0], arr[1]);
      else E.replaceSelection(arr.length==1 ? content : arr.join(E.getSelection()), 'end');
    }
    if (!editor.hasClass(E.buttons[bindex], 'stay-clicked')) E.focus();
  }
  catch (e) { alert(e.name +': '+ e.message); }
  return false;
}

//return html of editor buttons

editor.template = function () {
  if (typeof editor.tplHTML != 'undefined') return editor.tplHTML;
  editor.tplHTML = '';
  var buttons = [];
  for (var i=0, j=0; b=editor.buttons[i]; i++) {
    if (b[0].substr(0, 4) == 'tpl:') {
      editor.tplHTML += b[1];
      continue;
    }
    if (b[1].substr(0, 3) == 'js:') b[4] = new Function('E', b[1].substr(3));
    var inner = b[2].search(/\.(png|gif|jpg|jpeg|svg)$/i) != -1 ? ('type="image" src="'+ editor.path +'icons/'+ b[2] +'" class="editor-image-button"') : ('type="button" value="'+ b[2] +'" class="editor-text-button"');
    editor.tplHTML += '<input '+ inner +' onclick="editor.buttonClick(%n, '+ j +'); return false;" id="editor-%n-button-'+ j +'" title="'+ b[0] +'" accesskey="'+ b[3] +'" />';
    buttons[j] = b;
    j++
  }
  editor.buttons = buttons;
  return editor.tplHTML;
}

//integrate the editor into textarea T
editor.processTextarea = function (T) {
  if (T.editor || T.style.display == 'none' || T.style.visibility == 'hidden') return;
  var index = editor.instances.length;
  var ec = document.createElement('div');
  ec.id = 'editor-'+ index;
  ec.className = 'editor-container';
  ec.innerHTML = editor.template().replace(/\%n/g, index);
  T.parentNode.insertBefore(ec, T);
  var E = editor.instances[index] = new editor.instance(T, index);
  T.onfocus = function () { 
    if (!(editor.active == this.editor || editor.dialog.editor)) {
      editor.active.accesskeys(false);
      this.editor.accesskeys(true);
      editor.active = this.editor;
    }
  }
  if (index==0) {
    editor.active = E;
    editor.dialog.popup = editor.createPopup('editor-dialog');
    editor.dialog.popup.close = function () {editor.dialog.close();}
  }
  else E.accesskeys(false);
}

//create/open editor popup object
editor.openPopup = function (id, title, content) {
  var popup = editor.createPopup(id);
  popup.open(title, content);
  return popup;
}
editor.createPopup = function (pid, ptitle, pcontent) {
  if (editor.popups[pid]) {
    return editor.popups[pid];
  }
  var popup = editor.popups[pid] = document.createElement('table');
  with(popup) {
    with(insertRow(0)) {
      className = 'head even';
      with(insertCell(0)) {className = 'titl'; innerHTML = ptitle||''}
      with(insertCell(1)) {className = 'close'; innerHTML = '<a>x</a>';}
    }
    with(insertRow(1)) {
      className = 'body odd';
      with(insertCell(0)) {className = 'cntent'; colSpan = 2; innerHTML = pcontent||''}
    }
    rows[0].onmousedown = function (e) {
      var e = e||window.event;
      var P = editor.popups[pid];
      var X = e.clientX-parseInt(P.style.left||0);
      var Y = e.clientY-parseInt(P.style.top||0);
      document.onmousemove = function (e) {
        var e = e||window.event;
        P.style.left = (e.clientX-X) + 'px';
        P.style.top = (e.clientY-Y) + 'px';
        return false;
      }
      document.onmouseup = function (e) {
        document.onmousemove = null;
        document.onmouseup = null;
      }
      return false;
    }
    rows[0].cells[1].firstChild.onclick = function() {
      editor.popups[pid].close();
    }
    id = pid;
    className = 'editor-popup';
    style.position = 'absolute';
    style.display = 'none';
  }
  popup.open = function (title, content, keeppos) {
    if (typeof(title) == 'string') this.rows[0].cells[0].innerHTML = title;
    if (typeof(content) == 'string') this.rows[1].cells[0].innerHTML = content;
    if (!keeppos) {
      this.style.left = editor.absPos(editor.active.textArea, 'x') +'px';
      this.style.top = editor.absPos(editor.active.textArea, 'y')-25 +'px';
    }
    this.style.display = 'block';
    this.ed = editor.active;
  }
  popup.close = function () {
    this.style.display = 'none';
  }
  document.body.appendChild(popup);
  return popup;
}

//dialog functions
editor.dialog.open = function (title, content) {
  if (this.editor) this.close();
  this.editor = editor.active;
  this.editor.buttonsDisabled(true);
  editor.addClass(this.editor.buttons[this.editor.bindex], 'stay-clicked');
  this.esp = this.editor.posSelection();
  this.popup.open(title, content);
  this.oldfocus = this.editor.textArea.onfocus;
  this.editor.textArea.onfocus = function () {this.blur();}
}
editor.dialog.close = function () {
  if (this.editor) {
    this.editor.textArea.onfocus = this.oldfocus;
    this.editor.buttonsDisabled(false);
    editor.delClass(this.editor.buttons[this.editor.bindex], 'stay-clicked');
    if (this.editor == editor.active) {// restore previous states
      if (editor.mode == 2) this.editor.makeSelection(this.esp.start, this.esp.end); // selection for IE
      else this.editor.focus(); // focus for FF
    }
    this.editor = null;
    this.esp = null;
    this.popup.style.display = 'none';
  }
}

//custom functions
//return absolute position of element el on the axis(x or y)
editor.absPos = function (el, axis) {
  var prop = axis=='x' ? 'offsetLeft' : 'offsetTop';
  var pos = el[prop]||0;
  while (el = el.offsetParent) pos += el[prop];
  return pos;
}

//css class functions.
editor.hasClass = function (el, name) {
  return el.className && (' '+ el.className +' ').indexOf(' '+name+' ') != -1;
}
editor.addClass = function (el, name) {
  if (!editor.hasClass(el, name)) el.className += ' '+name;
}
editor.delClass = function (el, name) {
  if (editor.hasClass(el, name)) el.className = el.className.replace(new RegExp('(^| +)'+name+'( +|$)', 'g'), ' ');
}

//in_array implementation
editor.inArray = function (obj, arr) {
  for (var i in arr) if (arr[i] == obj) return true;
}

//escape regular expression specific characters
editor.regEsc = function (text) {
  return text.replace(/([\\\^\$\*\+\?\.\(\)\[\]\{\}\|])/g, '\\$1');
}

// browser specific functions.
if (editor.mode == 0) {//mode 0 - selection handling not-supported
  editor.selPos = function (T) {return {start: T.value.length, end: T.value.length};}
  editor.selMake = function (T, start, end) {}
}
else if (editor.mode == 1) {//mode 1 - Firefox, opera, safari.
  editor.selPos = function (T) { return {start: T.selectionStart||0, end: T.selectionEnd||0};}
  editor.selMake = function (T, start, end) {T.setSelectionRange(start, end);}
}
else if (editor.mode == 2) {//mode 2 - IE.
  editor.selPos = function (T) {
    T.focus();
    var val = T.value.replace(/\r\n/g, '\n');
    var mark = '~`^'; //dummy text.
    for (var i = 0; val.indexOf(mark) != -1; i++) mark += mark.charAt(i); //make sure mark is unique.
    var mlen = mark.length;
    var range = document.selection.createRange();
    var bm = range.getBookmark();
    var slen = range.text.replace(/\r\n/g, '\n').length;
    range.text = mark;
    var tmp = T.value.replace(/\r\n/g, '\n');
    var start = tmp.indexOf(mark);
    for (var i = 0; tmp.charAt(start+i+mlen)=='\n'; i++);
    var end = start+slen;
    for (; val.charAt(end)=='\n'; end++);
    end -= i;
    T.value = val;
    if (start == end && !val.charAt(end)) range.collapse(false);//bookmark has problems with a cursor at the end
    else range.moveToBookmark(bm);
    range.select();
    return {start: start, end: end};
  }
  editor.selMake = function (T, start, end) {
    range = T.createTextRange();
    range.collapse();
    range.moveEnd('character', end);
    range.moveStart('character', start);
    range.select();
  }
}
editor.processText = function (text) {
  return editor.mode == 2 ? text.replace(/\r\n/g, '\n') : text;
}

//initiate
if (document.getElementsByTagName && document.createElement  && document.getElementById) {
  var wload = window.onload;
  window.onload = typeof(wload)=='function' ? function(e) {wload(e); editor.initiate();} : editor.initiate;
}
