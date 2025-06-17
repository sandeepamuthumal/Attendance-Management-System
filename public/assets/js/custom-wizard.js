// JavaScript Document
(function() {
	
    var wizard = {
    formstate: 0,
    emptyInputs: 0,
    inactiveSections: [1,2],
    setInactiveSections: function(){
        if(this.formstate === 0)
            {
              this.inactiveSections = [1,2];  
            }
        else if(this.formstate === 1)
            {
              this.inactiveSections = [0,2];    
            }
        else
            {
          this.inactiveSections = [0,1];   	  
            }
    },
   setInactiveCircles:function(){
        if(this.formstate === 0)
            {
        var inactiveCirclea = document.querySelector(this.circlesections[this.inactiveSections[0]]);
        var inactiveCircleb = document.querySelector(this.circlesections[this.inactiveSections[1]]); 
      inactiveCirclea.classList.remove("activecirculo");
      inactiveCircleb.classList.remove("activecirculo");
            }
        else if(this.formstate === 1)
            {
       var inactiveCircles = document.querySelector(this.circlesections[this.inactiveSections[1]]);
         inactiveCircles.classList.remove("activecirculo");
  
            }
      
    },	  
    formsections: ['#aboutcont','#addrescont','#verifycont'],
    circlesections: ['.aboutblock .circulo','.addressblock .circulo','.verifyblock .circulo'],	  
    prevbtn: 'prevbtn',
    nextbtn: 'nextbtn',
          
    initiateForm: function(){
      
        var currsection = document.querySelector(this.formsections[this.formstate]);
        var inactiveSecta = document.querySelector(this.formsections[this.inactiveSections[0]]);
        var inactiveSectb=document.querySelector(this.formsections[this.inactiveSections[1]]);
        
        
        var currcircle = document.querySelector(this.circlesections[this.formstate]);
        
        
        var progressbar = document.querySelector('#progresswizard');
        var currsectionprogress = currsection.getAttribute('data-progress');
        
        progressbar.style.width = currsectionprogress;
        currsection.style.display = "block";
        inactiveSecta.style.display = "none";
        inactiveSectb.style.display = "none";
        
        
       if(this.formstate === 0)
           {
      document.getElementById(this.prevbtn).style.display = "none";		 
           }
        else
            {
          document.getElementById(this.prevbtn).style.display = "inline-block";		  
            }
        
      currcircle.classList.add("activecirculo");
      this.setInactiveCircles();
        
        
        if(this.formstate === 2){
          document.querySelector("#nextbtn").style.display = "none";
          document.querySelector("#submitForm").style.display = "inline-block";	 	  
            }
        else{
          document.querySelector("#nextbtn").style.display = "inline-block";
          document.querySelector("#submitForm").style.display = "none";	  
            }
        
        this.checkInput();
    },
  nextSection: function(){
      this.validateInput();
      if(this.emptyInputs === 0)
          {
      if(this.formstate < 2)
          {
              
          this.formstate++;
      this.setInactiveSections();
      wizard.initiateForm();
          }
      }
          
  },
  prevSection:function(){
      if(this.emptyInputs === 0){
          if(this.formstate>0)
          {
          this.formstate--;
      this.setInactiveSections();
      wizard.initiateForm();
          }
      }
  },
  validateInput:function(){
      
      var currsection = this.formsections[this.formstate];
      
      
  var inputfields = document.querySelectorAll(currsection + " input");
      for(var i = 0; i < inputfields.length; i++)
  {
     if(inputfields[i].value.length === 0)
         {
          inputfields[i].classList.add("is-invalid");
          this.emptyInputs++;
         }
  }
      
      
  },
  checkInput:function(){
        
      var currsection = this.formsections[this.formstate];
      var inputfields=document.querySelectorAll(currsection + " input");
          for(var i = 0; i < inputfields.length; i++)
  {
      var currElement = inputfields[i];
        currElement.addEventListener('focusout', inputValidation, false);			
  }
      function inputValidation(event){
          console.log(event.target.id);
          
          var currentInput=document.getElementById(event.target.id);
          
          if(currentInput.value.length > 3)
              {
              currentInput.classList.remove("is-invalid");
                  if(wizard.emptyInputs > 0)
                      {
                      wizard.emptyInputs--;	
                      }
              }
          console.log(wizard.emptyInputs);
      }
    }	  
    };
  
      
      wizard.initiateForm();
      
      document.getElementById(wizard.nextbtn).addEventListener("click", function(){wizard.nextSection();});
      document.getElementById(wizard.prevbtn).addEventListener("click", function(){wizard.prevSection();});
      
      
      
      
  })();