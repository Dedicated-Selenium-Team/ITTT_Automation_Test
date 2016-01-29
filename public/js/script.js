$(document).ready(function() {
  $('#designation').on('change', function() {
    $('#create-user #designation-id, #edit-user #designation-id').val($(this).val());
  });

  $('#role').on('change', function() {
    $('#create-user #role-id, #edit-user #role-id').val($(this).val());
  });

  $('#client').on('change', function() {
    $('#create-project #client-id, #edit-project #client-id').val($(this).val());
  });

  var designationId = $('#edit-user #designation-id').val(),
      roleId        = $('#edit-user #role-id').val(),
      clientId      = $('#edit-project #client-id').val();

  if(designationId) {
    $('#designation option').each(function() {
      if($(this).val() == designationId) {
        $(this).attr('selected', 'selected');
      }
    });
  }

  if(roleId) {
    $('#role option').each(function() {
      if($(this).val() == roleId) {
        $(this).attr('selected', 'selected');
      }
    });
  }

  if(clientId) {
    $('#client option').each(function() {
      if($(this).val() == clientId) {
        $(this).attr('selected', 'selected');
      }
    });
  }

  $('#create-project #add-pm, #edit-project #add-pm').on('click', function() {
    var pmNames = [];
    $(this).parents('.form-group').children('#project-manager').children('option:selected').each(function() {
      var pmId   = $(this).val(),
          pmName = $(this).text();
      if(pmId) {
        pmNames[pmId] = pmName;
        $(this).parents('.form-group').children('.names-main-wrapper').append('<div class="pm-name-wrapper">\n\
          <span class="pm-name">' + pmName + '</span><input type="text" name="resource-hours[]"><span pm-id="' + pmId + '" class="remove" \n\
          >Remove</span><input type="hidden" name="resource-id[]" \n\
          value="' + pmId + '" class="pm-id"><input type="hidden" name="designation-id[]" value="3" class="designation-id"></div>');
      }
    });
    for(var k in pmNames) {
      $(this).parents('.form-group').children('#project-manager').children('option').each(function() {
        if(k === $(this).val()) {
          $(this).remove();
        }
      });
    }
  });

  $(document).on('click', '.pm-name-wrapper .remove', function() {
      var value = $(this).parent('.pm-name-wrapper').children('.pm-id').val(),
          name  = $(this).parent('.pm-name-wrapper').children('.pm-name').html();
      $(this).parents('.form-group').children('#project-manager').append('<option value="' + value + '">' + name + '</option>');
      $(this).parent('.pm-name-wrapper').remove();
  });

  $('#create-project #add-developer, #edit-project #add-developer').on('click', function() {
    var devNames = [];
    $(this).parents('.form-group').children('#developer').children('option:selected').each(function() {
      var devId   = $(this).val(),
          devName = $(this).text();
      if(devId) {
        devNames[devId] = devName;
        $(this).parents('.form-group').children('.names-main-wrapper').append('<div class="dev-name-wrapper">\n\
          <span class="dev-name">' + devName + '</span><input type="text" name="resource-hours[]"><span dev-id="' + devId + '" class="remove" \n\
          >Remove</span><input type="hidden" name="resource-id[]" \n\
          value="' + devId + '" class="dev-id"><input type="hidden" name="designation-id[]" value="1" class="designation-id"></div>');
      }
    });
    for(var k in devNames) {
      $(this).parents('.form-group').children('#developer').children('option').each(function() {
        if(k === $(this).val()) {
          $(this).remove();
        }
      });
    }
  });

  $(document).on('click', '.dev-name-wrapper .remove', function() {
      var value = $(this).parent('.dev-name-wrapper').children('.dev-id').val(),
          name  = $(this).parent('.dev-name-wrapper').children('.dev-name').html();
      $(this).parents('.form-group').children('#developer').append('<option value="' + value + '">' + name + '</option>');
      $(this).parent('.dev-name-wrapper').remove();
  });

  $('#create-project #add-qa, #edit-project #add-qa').on('click', function() {
    var qaNames = [];
    $(this).parents('.form-group').children('#quality-analyst').children('option:selected').each(function() {
      var qaId   = $(this).val(),
          qaName = $(this).text();
      if(qaId) {
        qaNames[qaId] = qaName;
        $(this).parents('.form-group').children('.names-main-wrapper').append('<div class="qa-name-wrapper">\n\
          <span class="qa-name">' + qaName + '</span><input type="text" name="resource-hours[]"><span qa-id="' + qaId + '" class="remove" \n\
          >Remove</span><input type="hidden" name="resource-id[]" \n\
          value="' + qaId + '" class="qa-id"><input type="hidden" name="designation-id[]" value="2" class="designation-id"></div>');
      }
    });
    for(var k in qaNames) {
      $(this).parents('.form-group').children('#quality-analyst').children('option').each(function() {
        if(k === $(this).val()) {
          $(this).remove();
        }
      });
    }
  });

  $(document).on('click', '.qa-name-wrapper .remove', function() {
      var value = $(this).parent('.qa-name-wrapper').children('.qa-id').val(),
          name  = $(this).parent('.qa-name-wrapper').children('.qa-name').html();
      $(this).parents('.form-group').children('#quality-analyst').append('<option value="' + value + '">' + name + '</option>');
      $(this).parent('.qa-name-wrapper').remove();
  });

  $('#create-project #add-design, #edit-project #add-design').on('click', function() {
    var designNames = [];
    $(this).parents('.form-group').children('#design').children('option:selected').each(function() {
      var designId   = $(this).val(),
          designName = $(this).text();
      if(designId) {
        designNames[designId] = designName;
        $(this).parents('.form-group').children('.names-main-wrapper').append('<div class="design-name-wrapper">\n\
          <span class="design-name">' + designName + '</span><input type="text" name="resource-hours[]"><span design-id="' + designId + '" class="remove" \n\
          >Remove</span><input type="hidden" name="resource-id[]" \n\
          value="' + designId + '" class="design-id"><input type="hidden" name="designation-id[]" value="4" class="designation-id"></div>');
      }
    });
    for(var k in designNames) {
      $(this).parents('.form-group').children('#design').children('option').each(function() {
        if(k === $(this).val()) {
          $(this).remove();
        }
      });
    }
  });

  $(document).on('click', '.design-name-wrapper .remove', function() {
      var value = $(this).parent('.design-name-wrapper').children('.design-id').val(),
          name  = $(this).parent('.design-name-wrapper').children('.design-name').html();
      $(this).parents('.form-group').children('#design').append('<option value="' + value + '">' + name + '</option>');
      $(this).parent('.design-name-wrapper').remove();
  });

  removeExistingResource('.existing-pm-name-wrapper', '#project-manager');
  removeExistingResource('.existing-dev-name-wrapper', '#developer');
  removeExistingResource('.existing-qa-name-wrapper', '#quality-analyst');
  removeExistingResource('.existing-design-name-wrapper', '#design');

  $('#create-timesheet .add-project, #edit-timesheet .add-project').on('click', function() {
    var projectNames = [];
    $(this).parents('.form-group').children('#project').children('option:selected').each(function() {
      var projectId   = $(this).val(),
          projectName = $(this).text();
      if(projectId) {
        projectNames[projectId] = projectName;
        projectDetailStructure = '<tr><td class="project-name">' + projectName + '</td><td class="project-hours"><input type="text" name="project-hours[]"><span project-id="' + projectId + '" class="remove">Remove</span><input type="hidden" name="project-id[]" value="' + projectId + '"></td></tr>';
        $('#create-timesheet .project-data tbody, #edit-timesheet .project-data tbody').append(projectDetailStructure);
      }
    });
    for(var k in projectNames) {
      $(this).parents('.form-group').children('#project').children('option').each(function() {
        if(k === $(this).val()) {
          $(this).remove();
        }
      });
    }
  });

  $(document).on('click', 'table.project-data .remove', function() {
      var value = $(this).attr('project-id'),
          name  = $(this).parents('tr').children('.project-name').html();
      $('#project').append('<option value="' + value + '">' + name + '</option>');
      $(this).parents('tr').remove();
  });

  $('#create-timesheet .add-activity, #edit-timesheet .add-activity').on('click', function() {
    var activityNames = [];
    $(this).parents('.form-group').children('#activity').children('option:selected').each(function() {
      var activityId   = $(this).val(),
          activityName = $(this).text();
      if(activityId) {
        activityNames[activityId] = activityName;
        activityDetailStructure = '<tr><td class="activity-name">' + activityName + '</td><td class="activity-hours"><input type="text" name="activity-hours[]"><span activity-id="' + activityId + '" class="remove">Remove</span><input type="hidden" name="activity-id[]" value="' + activityId + '"></td></tr>';
        $('#create-timesheet .activity-data tbody, #edit-timesheet .activity-data tbody').append(activityDetailStructure);
      }
    });
    for(var k in activityNames) {
      $(this).parents('.form-group').children('#activity').children('option').each(function() {
        if(k === $(this).val()) {
          $(this).remove();
        }
      });
    }
  });

  $(document).on('click', 'table.activity-data .remove', function() {
      var value = $(this).attr('activity-id'),
          name  = $(this).parents('tr').children('.activity-name').html();
      $('#activity').append('<option value="' + value + '">' + name + '</option>');
      $(this).parents('tr').remove();
  });

  $('.my-projects-main-wrapper .add-resource').on('click', function() {
    var resourceNames = [];
    $(this).parents('.form-group').children('.resource').children('option:selected').each(function() {
      var resourceInfo = $(this).val(),
          resourceId   = $(this).val().split(' ')[0],
          designationId = $(this).val().split(' ')[1],
          resourceName = $(this).text();
      if(resourceInfo) {
        resourceNames[resourceInfo] = resourceName;
        resourceDetailStructure = '<div class="resource-wrapper"><span class="resource-name">' + resourceName + '</span><input type="text" name="resource-hours[]"><span resource-id="' + resourceId + '" class="remove">Remove</span><input type="hidden" name="resource-id[]" value="' + resourceId + '"><input type="hidden" name="designation-id[]" value="' + designationId + '" class="designation-id"></div>';
        $(this).parents('.resource').siblings('.resource-names-main-wrapper').append(resourceDetailStructure);
      }
    });
    for(var k in resourceNames) {
      $(this).parents('.form-group').children('.resource').children('option').each(function() {
        if(k === $(this).val()) {
          $(this).remove();
        }
      });
    }
  });

  $(document).on('click', '.my-projects-wrapper .remove', function() {
      var value = $(this).attr('resource-id'),
          name  = $(this).parents('.resource-wrapper').children('.resource-name').html();
      $(this).parents('.resource-names-main-wrapper').siblings('.resource').append('<option value="' + value + '">' + name + '</option>');
      $(this).parents('.resource-wrapper').remove();
  });

  removeExistingTimesheetEntry('.project-data', '.existing-project-main-wrapper', '#project');

  removeExistingTimesheetEntry('.activity-data', '.existing-activity-main-wrapper', '#activity');

  $('.hide-select-date-wrapper').hide();
  $('#create-prev-timesheet-wrapper').on('click', function() {
    $('.hide-select-date-wrapper').slideToggle();
    $('#create-prev-timesheet-btn').on('click', function(event) {
      event.preventDefault();
      var selectedDate = $(this).siblings('.selected-date').val(),
          csrfToken = $(this).siblings('.csrf-token').val();
      if(!selectedDate) {
        alert('Please select date first.');
      } else {
        $.ajax({
          type: "POST",
          url: './createPreviousTimesheet',
          data: {
            "_token": csrfToken,
            'selectedDate': selectedDate
          },
          success: function(data) {
            if(data == 'Timesheet not created') {
              location.replace("http://localhost:8000/create-timesheet/" + selectedDate);
            } else {
              $('#timesheet-created-message').html(data);
            }
          }
        })
      }
    });
  });

  $('.tab').click(function () {
    $('#tabs_container > .tabs > li.active a').removeClass('tab-log').addClass('de-active');
    $('#tabs_container > .tabs > li.active').removeClass('active');

    $(this).addClass('tab-log').removeClass('de-active');
    $(this).parent().addClass('active');

    $('#tabs_container > .tab_contents_container > div.tab_contents_active').removeClass('tab_contents_active');
    $(this.rel).addClass('tab_contents_active');
  });

  $('.project-resource-details .project-wrapper .project-name span').on('click', function() {
    $(this).parent('.project-name').siblings('.project-details').slideToggle();
  });

  $('.resource-project-details .resource-wrapper .resource-name span').on('click', function() {
    $(this).parent('.resource-name').siblings('.resource-project-wrapper').slideToggle();
  });

});

function removeExistingResource(resourceWrapper, resourceName) {
  $('#edit-project .form-group').each(function() {
    var userIdArray = [];
    if($(this).children('.existing-names-main-wrapper').length != 0) {
      $(this).children('.existing-names-main-wrapper').children(resourceWrapper).each(function() {
        var userId = $(this).children('.user-id').val();
        if(userId) {
           userIdArray.push(userId);
         }
      });
      $(this).children(resourceName).children('option').each(function() {
        if(userIdArray.indexOf($(this).val()) >= 0) {
          $(this).remove();
        }
      });
    }
  });
}

function removeExistingTimesheetEntry(entryData, entryWrapper, entryName) {
  var entryIdArray = [];
  if($(entryData).children(entryWrapper).length != 0) {
    $(entryData).children(entryWrapper).children('.existing-entry').children('td').each(function() {
      if($(this).children('input').length != 0) {
        var entryId = $(this).find('input[type=hidden]').val();
        if(entryId) {
          entryIdArray.push(entryId);
        }
      }
    });
    $('#edit-timesheet .form-group-wrapper .form-group').children(entryName).children('option').each(function() {
      if(entryIdArray.indexOf($(this).val()) >= 0) {
        $(this).remove();
      }
    });
  }
}
