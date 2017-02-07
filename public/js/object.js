/***************************************************/
// this will calculate the calculation function
/***************************************************/
function Calculate() {
  var _totalWorkingDays = 21.75;
  _totalWorkingHours = 8,
  effectiveHours = 0,
  totDays = 0;

  // getVal @para ----> class of input fields 
 // getVal @return ----> array
 this.getVal = function ( getClass ) {
   var countClass = $(getClass).length,
   holdValues = [];
   for (var i=0; i < countClass; i++ ) {
     holdValues[i] = Number($(getClass).eq(i).val());
     this.holdValues = holdValues[i];
   }
   return holdValues;
 }

  // getVal @para ----> class of spans
 // getVal @return ----> array
 this.getValText = function ( getClass ) {
   var countClass = $(getClass).length,
   holdValues1 = [];
   for (var i=0; i < countClass; i++ ) {
     holdValues1.push(Number($(getClass).eq(i).text()));
     this.holdValues1 = holdValues1[i];
   }
   return holdValues1;
 }
 this.totDesignation = function ( array ) {
  var addArray = array,
  total = 0;
  array.forEach(function(entry) {
    entry1 = parseFloat(entry);
    total = total + entry1;
  });
  return total;
},
  // add @return ----> Number
  this.add = function ( array ) {
    var addArray = array,
    total = 0;
    totDays = addArray.shift();
    array.forEach(function(entry) {
      entry1 = parseFloat(entry);
      total = total + entry1;
      effectiveHours = Number(total / _totalWorkingHours).toFixed(4);
    });
    this.effectiveHours = effectiveHours;
    return effectiveHours;
  }

  this.days = function (array,effeciveResource) {
    var tot = totDays * effeciveResource;
    return tot.toFixed(4);
  }

  this.Hour = function (effeciveDays) {
    var tot = _totalWorkingHours * effeciveDays;
    return tot.toFixed(2);
  }

  this.Months = function (days) {
    var tot = totDays / _totalWorkingDays;
    return tot.toFixed(2);
  }
  this.eqiMonths = function (days) {
    var tot = days / _totalWorkingDays;
    return tot.toFixed(2);
  }

  this.Total = function(array) {
    var total = 0;
    array.forEach(function(entry) {
      entry1 = parseFloat(entry);
      total = total + entry1;
    });
    this.total = total;
    return total.toFixed(2);
  }
  this.addition = function(parameter1,parameter2) {
    if (parameter2 == '' || parameter2 == NaN){
      parameter2 = 0;
    }
    var tot = parseFloat(parameter1)+parseFloat(parameter2),
    result = parseFloat(tot);
    return result.toFixed(2);
  }
  this.effectiveResourceOverProject = function(parameter1,parameter2) {
    var tot = parameter1/parameter2;
    return tot.toFixed(2);
  }

  this.calbackword = function(parameter1,parameter2) {
    var tot = parameter1*parameter2;
    return tot.toFixed(2);
  }

  this.removeTester = function(parameter1,parameter2) {
    if (parameter2 == '' || parameter2 == NaN) {
      parameter2 = 0;
    }
    var tot = parseFloat(parameter1)-parseFloat(parameter2),
    result = parseFloat(tot);
    return result;
  }
  this.datecalculate = function(parameter1,parameter2,warranty_days,holidays) {

    var dsplit = parameter1.split("/");
    var firstDate = new Date(dsplit[2],dsplit[1]-1,dsplit[0]);

    var dsplit = parameter2.split("/");
    var secondDate = new Date(dsplit[2],dsplit[1]-1,dsplit[0]);

    var getTotDate = 0;

    if (typeof warranty_days === "undefined" || warranty_days==0) {
      var warranty_days=0;
    }
    if (typeof holidays === "undefined" || holidays==0) {
      var holidays=0;
    }
    firstDate = new Date(firstDate.setDate(firstDate.getDate() - 1));
    while(firstDate < secondDate) {
      firstDate = new Date(firstDate.setDate(firstDate.getDate() + 1));
      if (firstDate.getDay() !=0 && firstDate.getDay()!=6 ) {
        getTotDate++;
      };
    }
    if(warranty_days==0)
    {
      getTotDate=getTotDate-holidays;
    }
    if(getTotDate<=0)
      getTotDate=0;
    return getTotDate;


  }
  this.addWarranty = function(p2Date,warranty_days,holidays) {
    var dsplit = p2Date.split("/");
    var p2ConvertedDate=new Date(dsplit[2],dsplit[1]-1,dsplit[0]);

    if(warranty_days==0 || warranty_days == '')
    {
      var numberOfDaysToAdd = 0;
    }
    else
    {
      var numberOfDaysToAdd = Number(warranty_days);
    }

    if(holidays==0 ||  holidays == '')
    {
     var holidays=0;
   }
   else
   {
    var holidays=Number(holidays)+1;
    numberOfDaysToAdd = numberOfDaysToAdd+holidays;
  }

  var phase2Date=new Date(p2ConvertedDate);
  if(numberOfDaysToAdd==0)
  {
   var dd = ('0' + (phase2Date.getDate())).slice(-2),
   mm = ('0' + (phase2Date.getMonth()+1)).slice(-2),
   yy = phase2Date.getFullYear();
   var newdate=dd+"/"+mm+"/"+yy;
   return newdate;
 }
 else
 {
  var count = 0;
  while(count<numberOfDaysToAdd)
  {
    phase2Date.setDate(phase2Date.getDate() + 1);
    if (phase2Date.getDay() !=0 && phase2Date.getDay()!=6 ) {
      count++;
    }
  }
  var dd = ('0' + (phase2Date.getDate())).slice(-2),
  mm = ('0' + (phase2Date.getMonth()+1)).slice(-2),
  yy = phase2Date.getFullYear();
  var newdate=dd+"/"+mm+"/"+yy;
  return newdate;
}

},  

this.timelineOverallDay = function(startDate,warrantyEndDate,holidays) {

  if(holidays==0 || holidays=='')
  {
    var totHolidays = 0;
  }
  else
  {
    var totHolidays = Number(holidays);
  }

  var dsplit = startDate.split("/");
  var startDate = new Date(dsplit[2],dsplit[1]-1,dsplit[0]);

  var dsplit = warrantyEndDate.split("/");
  var warrantyEndDate = new Date(dsplit[2],dsplit[1]-1,dsplit[0]);  

  var overalldays=0;
  var total = 0;
  
  startDate.setDate(startDate.getDate() - 1);
  
  while(startDate < warrantyEndDate)
  {
    startDate = new Date(startDate.setDate(startDate.getDate() + 1));
    if (startDate.getDay() !=0 && startDate.getDay()!=6 ) {
      overalldays++;
    }
  }
  total=overalldays-totHolidays;
  
  if(totHolidays>0)
    total=total-1;
  return total;
},
this.addwarrantyholiday=function(warranty_end_date,totHolidays)
{
  if(totHolidays==0 ||  totHolidays=='')
    var numberOfDaysToAdd = 0;
  else
    var numberOfDaysToAdd = Number(totHolidays);
  var new_warranty_end_date=new Date(warranty_end_date);
  if(numberOfDaysToAdd==0)
  {
   var dd = ('0' + (new_warranty_end_date.getDate())).slice(-2),
   mm = ('0' + (new_warranty_end_date.getMonth()+1)).slice(-2),
   yy = new_warranty_end_date.getFullYear();
   var newdate=dd+"/"+mm+"/"+yy;
   return newdate;
 }
 else
 {
  var count = 0;
  while(count<numberOfDaysToAdd)
  {
    new_warranty_end_date.setDate(new_warranty_end_date.getDate() + 1);
    if (new_warranty_end_date.getDay() !=0 && new_warranty_end_date.getDay()!=6 ) {
      count++;
    }
  }
  var dd = ('0' + (new_warranty_end_date.getDate())).slice(-2),
  mm = ('0' + (new_warranty_end_date.getMonth()+1)).slice(-2),
  yy = new_warranty_end_date.getFullYear();
  var newdate=dd+"/"+mm+"/"+yy;
  return newdate;
}
},
this.multiply = function(day,perHour) {
  var total = 0;
  total = Number(day * perHour).toFixed(2);
  return total;
},
this.percent = function(getCurrentValue) {
  var userValue = getCurrentValue,
  tot = Number((userValue/_totalWorkingHours)*100).toFixed(3);
  return tot;
}
}

///////////////////////////////////////////////////////////////////////////
///// This will add the row to the perticuler row based on phase
///////////////////////////////////////////////////////////////////////////

/***************************************************/
// this will get the Phase functionality
/***************************************************/

var phases = function() {
  var intf = {};
  intf.name;

  intf.setname = function(name,phaseName) {
    intf.name = name;
    intf.Phasename = phaseName;
  },

  intf.createResource = function(phaseId){
    var phase_id = phaseId,
    phaseData = phaseId;

    if ( phaseData == phaseId) {
      var newRow = $('<tr class="aaa"><td>'+ this.name +'</td><td></td> \
        <td></td><td></td> \
        <td> <input type="text" name="'+ this.Phasename +'" class="'+this.Phasename+'"></td><td><span class="'+ this.name +'_work_per_day">0%</span></td> \
        <td></td><td></td> \
        <td><span class="hrs_cal_req_gather_'+ this.Phasename +'"></span><span>0</span></td><td></td></tr>');
      // $('[data-phase-id="'+(parseInt(phaseId)+1)+'"]').parent().before(newRow);
    }
    return newRow;
  },

  /* flag=1   value with colon
  flag=0   value with dot */
  intf.timeConvertion = function(param1,param2,flag) {
    if (param1.length <= 1) {
      intf.getMinute = param1+0;
    }else {
      intf.getMinute = param1;
    }
    intf.getHour = param2;

    intf.cnvertMinuit = 0;
    intf.Time = 0;
    minuts = 60;
    if (intf.getMinute == undefined) {
      return false;
    } else {
      if (flag == 1) {
        if (param1 == undefined || param1.length == 0 ) {
         param1 = 0; 
         intf.Time = param1 +"."+ param2;
       } else {
        if(param2 >= 60){
          var new_minute = param2 % 60;
          if(new_minute.toString().length == 1){
            new_minute = '0' + new_minute;
          }
          var b = Number(param2) / 60 ;
          new_hours = Number(param1) + Number(b);
          intf.Time = new_hours.toFixed(0) +"."+ new_minute;
        }
        else if(param2.toString().length == 1){
          param2 = '0' + param2;
          intf.Time = param1 +"."+ param2;
        }
        else {
          intf.Time = param1 +"."+ param2;
        }
      }

    } else if(flag == 0 ) {
      intf.cnvertMinuit = Number((minuts * intf.getMinute)/100).toFixed(0);
      if (intf.cnvertMinuit.length ==1) {
        intf.cnvertMinuit = ('0' + intf.cnvertMinuit).slice(-2);  // '04'
      }
      intf.Time = intf.getHour +"."+ intf.cnvertMinuit;
    } else {
      intf.Time = param1+".00";
    }
  }
  return intf.Time;
}
return intf;
}

/***************************************************/
// Eno Of Phase functionality
/***************************************************/


var resources = function(name2) {
  var intf = {};
  intf.timePerDay = 0;
  intf.utilization = 0;
  intf.hrs = 0;
  intf.name = name2;

  intf.init = function(name1) {
    intf.name = name1;
    return intf.name;
  }
  intf.month = function(name1) {
    intf.name = name1;
    return intf.name;
  }
  return intf;
}

/***************************************************/
// Temp basis calculations
/***************************************************/
var allDetails = [];

var totalCalculation = function () {
  this.getVal = function (getClass) {
    var countClass = $(getClass).length,
    holdValues = [];
    for (var i=0; i < countClass; i++ ) {
      holdValues[i] = Number($(getClass).eq(i).val());
    }
    return holdValues;
  }
}

//////////////////////////////////////////////////////////////////////////////////////////
///// This will calculate the my project Designation and assign project tab functionality
//////////////////////////////////////////////////////////////////////////////////////////

var warrantyCalculation = function(array,month) {
  var intf = {};
  intf.name = 0;
  intf.allResource = array;
  intf.months = month;
  var _totalWorkingDays = 21.75,
  _totalWorkingHours = 8;
  intf.effectiveHours = 0;
  var tot = 0,
  a = [];
  intf.val = 21.75;

  intf.init = function(name1) {
    intf.name = name1;
    intf.months = month;
    return intf.name;
  }
  intf.month = function(parameter1) {
    intf.tot = parameter1/intf.val;
    return intf.tot;
  }
  intf.effectiveResource = function(array) {
    var total = 0;
    entry1 = parseFloat(array);
    total = total + entry1;
    this.total = total;
    return total;
  }
  return intf;
}

/* calculate My project -> Add Myself to Project Calculation  starts here */

/* calculate My project -> Add Myself to Project Calculation ends here */
var addOnProject = function(value) {
  var obj = {};
  obj.getValue = value;

  obj.init = function(data) {
    obj.Adjusted = {};
    obj.adjustedEstimation = 0;
    obj.adjustedPlanning = 0;
    obj.actualHours = 0;
    obj.actualEstimationRatio = 0;
    obj.actualPlanningRatio = 0;
    obj.sum = 0;
    obj.adjusted_Estimation_Calculation_Array;
    obj.adjusted_Planning_Calculation_Array;

    obj.gettotAdjusted = 0;
    obj.gettotEstimation = 0;
    obj.gettotPlanning = 0;
    obj.gettotAcualToDate = 0;
    obj.getactualTotalHours = 0;
    obj.getactualEstimaionRatio = 0;
    obj.getactualPlanningRatio = 0;
    obj.remainingSelfAssignedTotal = 0;
    obj.remainingEstimationTotal = 0;
    obj.remainingPlanningTotal = 0;

    // if (obj.v == "assign-project") {
      obj.timesheetData = data.timesheet_hrs; 
    // } else {
      obj.timesheetData = data.timesheet_hrs;
    // }

    obj.totERatio = 0;

    var totAddition = obj.add(data),
    totAdjusted = obj.adjusted(data, totAddition);
    obj.adjustedEstimate(data);
    obj.adjustedPlan(data);
    obj.getTotActualToDate(data.timesheet_hrs);
    obj.totActualHrs(data.timesheet_hrs);
    obj.estimationRatio(data.timesheet_hrs);
    obj.planningRatio(data.timesheet_hrs);

    return obj;
  },

  obj.add = function(data){
    for (var key in data ) {
      if (key === 'projects') {
        var temp = this.sum;
        data[key].forEach(function(element,index) {
          temp += Number(element.required_hrs);
        });
      }
    }
    obj.sum = temp;
    if (obj.sum > 100) {
      obj.remainingSelfAssignedTotal = Number(100 - obj.sum).toFixed(2);
    } else {
      obj.remainingSelfAssignedTotal;
    }
    return obj.sum;
  },

  /* This will calculate the adjusted total */
  obj.adjusted = function(data,sum) {
    var getCalculation = [];
    calculation = 0,
    getTotal = sum;
    for (var key in data ) {
      if (key === 'projects') {
        data[key].forEach(function(element,index) {
          calculation = (Number(((element.required_hrs) / getTotal)*100)).toFixed(2);
          if(isNaN(calculation))
            calculation=0.00;
          getCalculation.push(calculation);
          obj.Adjusted = getCalculation;
        });
        getCalculation.forEach(function(item,index) {
          obj.gettotAdjusted += Number(item);
        });
      }
    }
    return obj.selfAdjusted;
  },

  /* This will calculate the adjusted estimaton hour */
  obj.adjustedEstimate = function(data) {
    var getEstimationCal = [],
    calculation = 0;
    for (var key in data ) {
      if (key === 'projects') {
        data[key].forEach(function(element,index) {
          calculation = (Number(((element.required_hrs) * data.hrs)/100)).toFixed(2);
          
          getEstimationCal.push(calculation);
          obj.adjustedEstimation = getEstimationCal;
        });
        getEstimationCal.forEach(function(item,index) {
          obj.gettotEstimation += (Number(item));
        });
        if (data.hrs < obj.gettotEstimation ) {
          obj.remainingEstimationTotal = Number(data.hrs -  obj.gettotEstimation).toFixed(2);
        } else {
          obj.remainingEstimationTotal = (obj.gettotEstimation).toFixed(2);
        }
      }
    }
    obj.adjusted_Estimation_Calculation_Array = getEstimationCal;
    console.log(obj.adjustedEstimation);
    return obj.adjustedEstimation;
  },

  /* This will calculate the adjusted planning hour */
  obj.adjustedPlan = function(data) {
    var getPlanningCal = [],
    temp = 0,
    calculation = 0;
    for (var key in data ) {
      if (key === 'projects') {
        data[key].forEach(function(element,index) {
          calculation = (Number(((element.required_hrs) * data.plan_hrs)/100)).toFixed(2);
          getPlanningCal.push(calculation);
          obj.adjustedPlanning = getPlanningCal;
        });
        getPlanningCal.forEach(function(item,index) {
          obj.gettotPlanning += Number(item);
        });
      }
      if (data.plan_hrs < obj.gettotPlanning ) {
        obj.remainingPlanningTotal = Number(data.plan_hrs -  obj.gettotPlanning).toFixed(2);
      } else {
        obj.remainingPlanningTotal = obj.gettotPlanning;
      }
    }
    obj.adjusted_Planning_Calculation_Array = getPlanningCal;
    return obj.adjustedPlanning;
  },

  obj.getTotActualToDate = function(timesheet) {
    obj.gettotAcualToDate=0;
    for (var i = 0; i < timesheet.length; i++) {
      obj.gettotAcualToDate += Number(timesheet[i].timesheet_hrs);
    }
  },

  /* This will calculate the actual hour's witch came from timesheet */
  obj.totActualHrs = function(timesheet) {


    var totalCalculation = [],
    calculation = 0;
    for (var i =0; i < timesheet.length; i++) {
      calculation = (Number(((timesheet[i].timesheet_hrs) / obj.gettotAcualToDate)*100)).toFixed(2);
      if (isNaN(calculation)) {
        calculation = 0;
      }
      totalCalculation.push(calculation);
      obj.actualHours = totalCalculation;
    }
    totalCalculation.forEach(function(item,index) {
      obj.getactualTotalHours += Number(item);
    });
    return obj.actualHours;
  },

  /* This will calculate the estimation Ratio */
  obj.estimationRatio = function(timesheet) {
    var calculation = 0;
    adjustedData = this.adjusted_Estimation_Calculation_Array,
    estimationRatio_Array = [];
    for (var i = 0; i < timesheet.length; i++) {
      calculation = (Number(((timesheet[i].timesheet_hrs)- adjustedData[i])/adjustedData[i])*100).toFixed(2);
      if(calculation=='undefined' || isNaN(calculation) || calculation =='Infinity')
      {
        calculation=0.00;
      }
      estimationRatio_Array.push(calculation);
      obj.actualEstimationRatio = estimationRatio_Array;
      obj.getactualEstimaionRatio = (Number((obj.gettotAcualToDate-obj.gettotEstimation)/obj.gettotEstimation)*100).toFixed(2);
      if(obj.getactualEstimaionRatio=='undefined' || isNaN(obj.getactualEstimaionRatio) || obj.getactualEstimaionRatio == 'Infinity')
        obj.getactualEstimaionRatio=0.00;
    }

    return obj.getactualEstimaionRatio;
  },

  /* This will calculate the planning Ratio */
  obj.planningRatio = function(timesheet) {
    var calculation = 0;
    adjustedPlanningData = obj.adjusted_Planning_Calculation_Array,
    planningRatio_Array = [];

    for( var i = 0 ; i < timesheet.length; i++ ) {
      calculation = (Number(((timesheet[i].timesheet_hrs)- adjustedPlanningData[i])/adjustedPlanningData[i])*100).toFixed(2);
      if(calculation=='undefined' || isNaN(calculation) || calculation =='Infinity')
      {
        calculation=0.00;
      }
      planningRatio_Array.push(calculation);
      obj.actualPlanningRatio = planningRatio_Array;
      obj.getactualPlanningRatio = (Number((obj.gettotAcualToDate-obj.gettotPlanning)/obj.gettotPlanning)*100).toFixed(2);
      if(obj.getactualPlanningRatio=='undefined' || isNaN(obj.getactualPlanningRatio) || obj.getactualPlanningRatio == 'Infinity')
      {
        obj.getactualPlanningRatio=0.00;
      }
    }
    return obj.getactualPlanningRatio;
  }
  return obj;
}


/******************** Calculation for after Assistement on project starts here ********************/
var addOnProjectAfterAssistment = function(value) {
  var obj = {};
  obj.getValue = value;

  obj.init = function(data) {
    obj.Adjusted = {};
    obj.adjustedEstimation = 0;
    obj.adjustedPlanning = 0;
    obj.actualHours = 0;
    obj.actualEstimationRatio = 0;
    obj.actualPlanningRatio = 0;
    obj.sum = 0;
    obj.adjusted_Estimation_Calculation_Array;
    obj.adjusted_Planning_Calculation_Array;

    obj.gettotAdjusted = 0;
    obj.gettotEstimation = 0;
    obj.gettotPlanning = 0;
    obj.gettotAcualToDate = 0;
    obj.getactualTotalHours = 0;
    obj.getactualEstimaionRatio = 0;
    obj.getactualPlanningRatio = 0;
    obj.remainingSelfAssignedTotal = 0;
    obj.remainingEstimationTotal = 0;
    obj.remainingPlanningTotal = 0;
    obj.getactualTotalHours = 0;

    obj.timesheetData = data.timesheet_hrs; 

    obj.totERatio = 0;

    var totAddition = obj.add(data),
    totAdjusted = obj.adjusted(data, totAddition);
    obj.adjustedEstimate(data);
    obj.adjustedPlan(data);
    obj.getTotActualToDate(data.timesheet_hrs);
    obj.totActualHrs(data.timesheet_hrs);
    obj.estimationRatio(data.timesheet_hrs);
    obj.planningRatio(data.timesheet_hrs);

    return obj;
  },

  obj.add = function(data){
    for (var key in data ) {
      if (key === 'projects') {
        var temp = this.sum;
        data[key].forEach(function(element,index) {
          temp += Number(element.required_hrs);
        });
      }
    }
    obj.sum = temp;
    if (obj.sum > 100) {
      obj.remainingSelfAssignedTotal = Number(100 - obj.sum).toFixed(2);
    } else {
      obj.remainingSelfAssignedTotal;
    }
    return obj.sum;
  },

  /* This will calculate the adjusted total */
  obj.adjusted = function(data,sum) {
    var getCalculation = [];
    calculation = 0,
    getTotal = sum;
    for (var key in data ) {
      if (key === 'projects') {
        data[key].forEach(function(element,index) {
          calculation = (Number(((element.required_hrs) / getTotal)*100)).toFixed(2);
          if(isNaN(calculation))
            calculation=0.00;
          getCalculation.push(calculation);
          obj.Adjusted = getCalculation;
        });
        getCalculation.forEach(function(item,index) {
          obj.gettotAdjusted += Number(item);
        });
      }
    }
    // obj.selfAdjusted = sum;
    return obj.selfAdjusted;
  },

  /* This will calculate the adjusted estimaton hour */
  obj.adjustedEstimate = function(data) {
    var getEstimationCal = [],
    calculation = 0;
    for (var key in data ) {
      if (key === 'projects') {
        obj.Adjusted.forEach(function(element,index) {
          calculation = (Number(((element) * data.hrs)/100)).toFixed(2);
          getEstimationCal.push(calculation);
          obj.adjustedEstimation = getEstimationCal;
        });
        getEstimationCal.forEach(function(item,index) {
          obj.gettotEstimation += (Number(item));
        });
        if (data.hrs < obj.gettotEstimation ) {
          obj.remainingEstimationTotal = Number(data.hrs -  obj.gettotEstimation).toFixed(2);
        } else {
          obj.remainingEstimationTotal = (obj.gettotEstimation).toFixed(2);
        }
      }
    }
    obj.adjusted_Estimation_Calculation_Array = getEstimationCal;
    return obj.adjustedEstimation;
  },

  /* This will calculate the adjusted planning hour */
  obj.adjustedPlan = function(data) {
    var getPlanningCal = [],
    temp = 0,
    calculation = 0;
    for (var key in data ) {
      if (key === 'projects') {
        obj.Adjusted.forEach(function(element,index) {
          calculation = (Number(((element) * data.plan_hrs)/100)).toFixed(2);

          getPlanningCal.push(calculation);
          obj.adjustedPlanning = getPlanningCal;
        });
        getPlanningCal.forEach(function(item,index) {
          obj.gettotPlanning += Number(item);
        });
      }
      if (data.plan_hrs < obj.gettotPlanning ) {
        obj.remainingPlanningTotal = Number(data.plan_hrs -  obj.gettotPlanning).toFixed(2);
      } else {
        obj.remainingPlanningTotal = obj.gettotPlanning;
      }
    }
    obj.adjusted_Planning_Calculation_Array = getPlanningCal;
    return obj.adjustedPlanning;
  },

  obj.getTotActualToDate = function(timesheet) {
    obj.gettotAcualToDate=0;
    for (var i = 0; i < timesheet.length; i++) {
      obj.gettotAcualToDate += Number(timesheet[i].timesheet_hrs);
    }

  },

  /* This will calculate the actual hour's witch came from timesheet */
  obj.totActualHrs = function(timesheet) {
    var totalCalculation = [],
    calculation = 0;
    for (var i =0; i < timesheet.length; i++) {
      calculation = (Number(((timesheet[i].timesheet_hrs) / obj.gettotAcualToDate)*100)).toFixed(2);
      if (isNaN(calculation)) {
        calculation = 0;
      }
      totalCalculation.push(calculation);
      obj.actualHours = totalCalculation;
    }
    totalCalculation.forEach(function(item,index) {
      obj.getactualTotalHours += Number(item);
    });
    return obj.actualHours;
  },

  /* This will calculate the estimation Ratio */
  obj.estimationRatio = function(timesheet) {
    var calculation = 0.00;
    adjustedData = this.adjusted_Estimation_Calculation_Array,
    estimationRatio_Array = [];
    for (var i = 0; i < timesheet.length; i++) {
      calculation = Number(Number(((timesheet[i].timesheet_hrs)- adjustedData[i])/adjustedData[i])*100).toFixed(2);
      if(calculation=='undefined' || isNaN(calculation) || calculation =='Infinity')
      {
        calculation=0.00;
      }
      estimationRatio_Array.push(calculation);
      obj.actualEstimationRatio = estimationRatio_Array;
      obj.getactualEstimaionRatio = (Number((obj.gettotAcualToDate-obj.gettotEstimation)/obj.gettotEstimation)*100).toFixed(2);
      if(obj.getactualEstimaionRatio=='undefined' || isNaN(obj.getactualEstimaionRatio) || obj.getactualEstimaionRatio =='Infinity')
      {
        obj.getactualEstimaionRatio=0.00;
      }
    }
    console.log('obj.getactualEstimaionRatio', obj.getactualEstimaionRatio);
    return obj.getactualEstimaionRatio;
  },

  /* This will calculate the planning Ratio */
  obj.planningRatio = function(timesheet) {
    var calculation = 0.00;
    adjustedPlanningData = obj.adjusted_Planning_Calculation_Array,
    planningRatio_Array = [];

    for( var i = 0 ; i < timesheet.length; i++ ) {
      calculation = (Number(((timesheet[i].timesheet_hrs)- adjustedPlanningData[i])/adjustedPlanningData[i])*100).toFixed(2);
      if(calculation=='undefined' || isNaN(calculation)|| calculation == 'Infinity')
      {
       calculation = 0.00;
     }
     planningRatio_Array.push(calculation);
     obj.actualPlanningRatio = planningRatio_Array;
     obj.getactualPlanningRatio = (Number((obj.gettotAcualToDate-obj.gettotPlanning)/obj.gettotPlanning)*100).toFixed(2);
     if(obj.getactualPlanningRatio=='undefined' || isNaN(obj.getactualPlanningRatio) || obj.getactualPlanningRatio == 'Infinity')
     {
      obj.getactualPlanningRatio=0.00;
    }
  }
  return obj.getactualPlanningRatio;
}
return obj;
}

/******************** Calculation for After Assistment on project ends here ************************/

var perUserCalculation = function() {
  var user = {};
  user.calculate = 0;
  user.total = 0;
  user.totalWorkingDaysInMonth = 21.75;

  user.init = function(data) {
    user.getMonths(data);
    // return user;
  },
  
  ////////////////////////////////////////////////////////////////////
  // This Will convert day to months
  ////////////////////////////////////////////////////////////////////
  
  user.getMonths = function(data){
    var getDays = data;
    user.total = (Number(getDays / user.totalWorkingDaysInMonth)).toFixed(3);
  }
  return user;
}

var ESTIMATE = function(value) {
  var intf = {};
  intf.init = function() {

  },
  intf.getPhase = function(data) {

  },
  intf.getVal = function ( getClass ) {
   var countClass = getClass.length;
   holdValues = [];

   return holdValues;
 }

 return intf; 
}

//////////////////////////////////////////////////////////////////////
// Code to calculate total hours and free time on timesheet
//////////////////////////////////////////////////////////////////////

function dayTotalHrs(n,classname){
  var arr = [];
  var element = $(classname+' tr td:nth-of-type('+n+')');
  var total = 0;
  var date = '01-01-1970 00:00:00';
  var new_date=new Date(1970,01,01,0,0,0);
  for(var i=0;i<element.length;i++){
    var hours_and_minutes=($(element[i]).text()).split(":");
    var hours=Number(hours_and_minutes[0]);
    var minutes=Number(hours_and_minutes[1]);
    new_date.setHours(new_date.getHours()+hours);
    new_date.setMinutes(new_date.getMinutes()+minutes);
  }

  var total_minutes=new_date.getMinutes();
  total_minutes= total_minutes > 9 ? "" + total_minutes: "0" + total_minutes;
  total=new_date.getHours()+":"+total_minutes;
  arr['total_hrs']=total;
  if(Number(new_date.getHours()+"."+new_date.getMinutes())< 08.30)
  {
    new_date.setHours(08-new_date.getHours());
    new_date.setMinutes(30-new_date.getMinutes()); 
    var free_time_hours=new_date.getHours();
    var free_time_minutes=new_date.getMinutes();
    free_time_minutes= free_time_minutes > 9 ? "" + free_time_minutes: "0" + free_time_minutes;
    var total_free_time = free_time_hours+":"+free_time_minutes;
  }
  else{
    total_free_time = "0:00"
  }
  arr['free_time']=total_free_time;
  return arr;
}

// var TIMECALCULATOR = function(){
//  var intf = {};
//  intf.total = 0;
//  intf.free_hours = 0;
//  intf.date = '01-01-1970 00:00:00';
//  new_date = new Date( intf.date );
//  intf.dayTotalHrs = function(n,classname) {
//    var element = $(classname+' tr td:nth-of-type('+n+')');
//    for(var i=0;i<element.length;i++) {
//      var hours_and_minutes=(element[i].outerText).split(":"),
//      hours = Number(hours_and_minutes[0]),
//      minutes=Number(hours_and_minutes[1]);
//      new_date.setHours(new_date.getHours()+hours);
//      new_date.setMinutes(new_date.getMinutes() + minutes);
//    }
//    var total_minutes=new_date.getMinutes();
//    total_minutes= total_minutes > 9 ? "" + total_minutes: "0" + total_minutes;
//    total=new_date.getHours()+":"+total_minutes;
//    if(Number(new_date.getHours()+"."+new_date.getMinutes())< 08.30)
//    {
//      var free_time_hours=(08-new_date.getHours());
//      free_time_minutes=(30-new_date.getMinutes()); 
//      free_hours = free_time_hours+":"+free_time_minutes;
//    } 
//    else
//      free_hours = "0:0";  
//    return {
//     'total-hrs':total,
//     'free-hrs':free_hours
//   };
// }
// return intf;
// }

function validateDate(date,mindate,thisEle){
  thisEle.siblings('.error').text('');
  thisEle.siblings('.error').hide();
  var reg = /^(?:(?:31(\/)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/;
  var currentDate = date;
  var minDate = Date.parse(mindate);
  var valueEntered = Date.parse(currentDate);
  if(!currentDate.match(reg)){
    thisEle.siblings('.error').text('Please enter a valid date');
    thisEle.siblings('.error').show();
  }
  else if(mindate!=0){
    if(valueEntered < minDate){
      thisEle.siblings('.error').text('Please check the min date');
      thisEle.siblings('.error').show();
    }
  }
  else {
    // thisEle.siblings('.error').text('');
    thisEle.siblings('.error').hide();
  }
}