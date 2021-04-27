<!-- HTML -->
<div style="margin-top:10px;">
                    <div class="optionsecoptions">
                        Computers
                    </div>
                    <div class="optionsecoptions" style="top:151px;">
                        Electronics
                    </div>
                    <div class="optionsecoptions" style="top:212px;">
                        Mechanical
                    </div>
                    <div class="optionsecoptions" style="top:273px;">
                        Electrical
                    </div>
                </div>


<a href="#" id="confirmBtn"> Confirm </a>
<!-- 
JAVASCRIPT -->
<script>
var selectedDiv = "";
var x = document.getElementsByClassName('optionsecoptions')
for (var i = 0; i < x.length; i++) {
    x[i].addEventListener("click", function(){
        
    var selectedEl = document.querySelector(".selected");
    if(selectedEl){
        selectedEl.classList.remove("selected");
    }
    this.classList.add("selected");
        
    }, false);;
}

document.getElementById('confirmBtn').addEventListener('click',function(){
    
    var selectedEl = document.querySelector(".selected");
    if(selectedEl)
        alert(selectedEl.innerText);    
    else
        alert('please choose an option')
})
</script>