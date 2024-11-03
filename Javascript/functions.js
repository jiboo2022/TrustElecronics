
function send(th,tok,nextid){
    if(isNaN(th)){
        alert('Only Numerical values are allowed !')
        document.getElementById(tok).value=''
    }else{
        //alert(th)
        var next= document.getElementById(nextid)
          if(next){
            next.focus()
          }
    }
  
  }