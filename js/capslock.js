function capsLock(e){
  var kc = e.keyCode ? e.keyCode : e.which;
  var sk = e.shiftKey ? e.shiftKey : kc === 16;
  var display = ((kc >= 65 && kc <= 90) && !sk) || 
      ((kc >= 97 && kc <= 122) && sk) ? 'block' : 'none';
  document.getElementById('caps').style.display = display
}