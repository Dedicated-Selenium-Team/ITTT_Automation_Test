var expect = require('chai').expect;

module.exports = function() {

	this.World = require('../../support/world.js').World;

    //open the browser
    this.Given(/^Open browser and Start Application "(.*?)"$/, function(url){
    	this.driver.get(url);
    });

    //enter username and password
    this.When(/^I enter valid Admin "(.*?)" and "(.*?)"$/, function(user,pass){
    	this.driver.findElement({ id: 'email' }).sendKeys(user);
    	this.driver.findElement({ id: 'password' }).sendKeys(pass);
    });

    //click on sign in button
    this.Then(/^User should be logged in and home page should be open$/,function(){
    	this.driver.findElement({ css: '.submit-btn'}).click();
    });

    //click on mouse hamburger
    this.Then(/^I click on mouse hamberger$/, function(){
    	this.driver.findElement({ css: '.nav-hamber'}).click();
    	this.driver.sleep(1000);
    });

    //click on user in list
    this.Then(/^I click User in list$/, function(){
    	this.driver.findElement({ css: '.user'}).click();
    	this.driver.sleep(1000);
    });

    //click on add new
    this.When(/^I click on add new button$/, function(){
    	this.driver.findElement({ css: '#admin-user'}).click();
    	this.driver.sleep(1000);
    });

    //popup is display or not
    this.Then(/^I should see a popup$/, function(){
    	this.driver.findElement({ css: '.modal-dialog' }).then(function(popup){
    		if(popup.isDisplayed()){
    			console.log("Popup is displayed");
    		}else{
    			console.log("Popup is not displayed");
    		}
    	});
    });

    //click the save entry button
    this.When(/^I click save entry button with empty field$/, function(){
      this.driver.findElement({ css: '#save'}).click();
      this.driver.sleep(1000);
    });

    //geting input fileld name and test its required or not
    this.Then(/^I should see errore message$/, function(){
      this.driver.findElements({ css:'#frm-create-user .form-control' }).then(function(error_list){
        for(var i=0; i<error_list.length; i++){
          var displayDate=error_list[i].getAttribute("name").then(function(field){
            console.log("Field name is: "+field);
          });

          var displayDate=error_list[i].getAttribute("required").then(function(field){
            console.log("Required for above field: "+field);
            console.log('');
          });
        }
      });
    });

    // this.When(/^I enter the "(.*?)", "(.*?)", "(.*?)", "(.*?)", "(.*?)", "(.*?)", "(.*?)"$/, function(name, contact, email, pass, month, year, date){
    //   this.driver.findElement({ id: 'fname' }).sendKeys(name);
    //   this.driver.sleep(1000);

    //   this.driver.findElement({ id: 'lname' }).sendKeys(name);
    //   this.driver.sleep(1000);

    //   this.driver.findElement({ id: 'designation' }).click();
    //   this.driver.findElement({ css: '#designation option:nth-of-type(3)' }).click();
    //   this.driver.sleep(1000);

    //   this.driver.findElement({ id: 'mobile_no' }).sendKeys(contact);
    //   this.driver.sleep(1000);

    //   this.driver.findElement({ id: 'joining_date' }).click();
    //   this.driver.sleep(1000);

    //     //Select Month from dropdown
    //     var desiredMonth;
    //     var selectMonth=this.driver.findElement({css:'.ui-datepicker-month'});
    //     selectMonth.click();
    //     selectMonth.findElements({css:'option'}).then(function findMatchingOption(options){
    //      options.some(function(option){
    //        option.getText().then(function doesOptionMatch(text){
    //          if (month === text){
    //            desiredMonth = option;
    //            return true;
    //          }
    //        });
    //      });
    //    })
    //     .then(function clickOption(){
    //      if (desiredMonth){
    //        desiredMonth.click();
    //      }
    //    });
    //     this.driver.sleep(2000);

    //     //Select Year from dropdown
    //     var desiredYear;
    //     var selectYear=this.driver.findElement({css:'.ui-datepicker-year'});
    //     selectYear.click();
    //     selectYear.findElements({css:'option'}).then(function findMatchingOption(options){
    //      options.some(function(option){
    //        option.getText().then(function doesOptionMatch(text){
    //          if (year === text){
    //            desiredYear = option;
    //            return true;
    //          }
    //        });
    //      });
    //    })
    //     .then(function clickOption(){
    //      if (desiredYear){
    //        desiredYear.click();
    //      }
    //    });
    //     this.driver.sleep(2000);

    //     // Select date and click
    //     this.driver.findElement({ css:'.ui-datepicker-calendar td:nth-of-type(6) a'}).click();
    //     this.driver.sleep(2000);     

    //     this.driver.findElement({ id: 'email' }).sendKeys(email);
    //     this.driver.sleep(1000);

    //     this.driver.findElement({ id: 'password' }).sendKeys(pass);
    //     this.driver.sleep(1000);

    //     this.driver.findElement({ id: 're-password' }).sendKeys(pass);
    //     this.driver.sleep(1000);

    //     this.driver.findElement({ id: 'role' }).click();
    //     this.driver.findElement({ css: '#designation option:nth-of-type(2)' }).click();
    //     this.driver.sleep(1000);

    //     this.driver.findElement({ css: '#save'}).click();
    //     this.driver.sleep(1000);

    //   });

    // this.Then(/^I should see error message$/, function(){
    //   this.driver.findElement({ css: '#DataTables_Table_0_wrapper' });
    // });

    

    //click on close icon
    this.When(/^I click on cross symbol top right$/, function(){
      this.driver.findElement({ css: '.close' }).then(function(close){
        close.click()
      });
      this.driver.sleep(1000);
    });

    //pop close confirmation
    this.Then(/^popup should be close$/, function(){
      this.driver.findElement({ css:'.admin-info #user' }).then(function(error_list){
        var displayDate=error_list.getAttribute("style").then(function(field){
          if(field=="display: none;"){
            console.log("");
            console.log("Result==>>after clicked on close icon popup is closed");
          }
        });
      });
    });

  //click on add new
  this.When(/^I click on ad new button$/, function(){
    this.driver.findElement({ css: '#admin-user'}).click();
    this.driver.sleep(1000);
  });

  this.When(/^I enter the "(.*?)", "(.*?)", "(.*?)", "(.*?)", "(.*?)", "(.*?)", "(.*?)"$/, function(name, contact, email, pass, month, year, date){
    this.driver.findElement({ id: 'fname' }).sendKeys(name);
    this.driver.sleep(1000);

    this.driver.findElement({ id: 'lname' }).sendKeys(name);
    this.driver.sleep(1000);

    this.driver.findElement({ id: 'designation' }).click();
    this.driver.findElement({ css: '#designation option:nth-of-type(3)' }).click();
    this.driver.sleep(1000);

    this.driver.findElement({ id: 'mobile_no' }).sendKeys(contact);
    this.driver.sleep(1000);

    this.driver.findElement({ id: 'joining_date' }).click();
    this.driver.sleep(1000);

        //Select Month from dropdown
        var desiredMonth;
        var selectMonth=this.driver.findElement({css:'.ui-datepicker-month'});
        selectMonth.click();
        selectMonth.findElements({css:'option'}).then(function findMatchingOption(options){
         options.some(function(option){
           option.getText().then(function doesOptionMatch(text){
             if (month === text){
               desiredMonth = option;
               return true;
             }
           });
         });
       })
        .then(function clickOption(){
         if (desiredMonth){
           desiredMonth.click();
         }
       });
        this.driver.sleep(2000);

        //Select Year from dropdown
        var desiredYear;
        var selectYear=this.driver.findElement({css:'.ui-datepicker-year'});
        selectYear.click();
        selectYear.findElements({css:'option'}).then(function findMatchingOption(options){
         options.some(function(option){
           option.getText().then(function doesOptionMatch(text){
             if (year === text){
               desiredYear = option;
               return true;
             }
           });
         });
       })
        .then(function clickOption(){
         if (desiredYear){
           desiredYear.click();
         }
       });
        this.driver.sleep(2000);

        // Select date and click
        this.driver.findElement({ css:'.ui-datepicker-calendar td:nth-of-type(6) a'}).click();
        this.driver.sleep(2000);     

        this.driver.findElement({ id: 'email' }).sendKeys(email);
        this.driver.sleep(1000);

        this.driver.findElement({ id: 'password' }).sendKeys(pass);
        this.driver.sleep(1000);

        this.driver.findElement({ id: 're-password' }).sendKeys(pass);
        this.driver.sleep(1000);

        this.driver.findElement({ id: 'role' }).click();
        this.driver.findElement({ css: '#designation option:nth-of-type(2)' }).click();
        this.driver.sleep(1000);

        this.driver.findElement({ css: '#save'}).click();
        this.driver.sleep(1000);

      });

  this.Then(/^I should see error message$/, function(){
    this.driver.findElement({ css: '#DataTables_Table_0_wrapper' });
  });

  // //I enter valid input 
    // this.When(/^I enter valid entry and click update$/, function(){

    //   this.driver.findElement({ id: 'fname' }).clear();
    //   this.driver.findElement({ id: 'fname' }).sendKeys("Test");
    //   this.driver.sleep(1000);

    //   this.driver.findElement({ id: 'email' }).clear();
    //   this.driver.findElement({ id: 'email' }).sendKeys("test@gmail.com");
    //   this.driver.sleep(1000);

    //   this.driver.findElement({ id: 'password' }).sendKeys("123456");
    //   this.driver.sleep(1000);

    //   this.driver.findElement({ id: 're-password' }).sendKeys("123456");
    //   this.driver.sleep(1000);

    //   this.driver.findElement({ id: 'save' }).click();
    //   this.driver.sleep(2000);

    // });

    // //checking error message is displaying or not
    // this.Then(/^I should not see any error message$/, function(){
    //   this.driver.findElements({ css: '.error' }).then(function(error_list){
    //     for(var i=0; i<error_list.length; i++){
    //       var error_value = error_list[i].getText().then(function(error){
    //         if(!error==""){
    //           console.log("Error messager for invalid fiels: "+error);
    //         }
    //       });
    //     }
    //   });
    // });

    // this.Then(/^Field are updated$/, function(){
    // });

  };