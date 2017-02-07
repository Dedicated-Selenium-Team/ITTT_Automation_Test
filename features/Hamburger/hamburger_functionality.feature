Feature: Hamburger 

Scenario Outline: Verify click hamburger item list and list hover

Given Open browser and Start Application "<url>"
When I enter valid "<username>" and "<password>"
Then User should be logged in and home page should be open

Then I click on mouse hamberger
Then I should see list of tab
When I click on close icon hamburger
Then Hamburger should be closed 

# you select list number: 1 => TimeSheet, 2 => Project, 3 => User
Then I click on mouses hamberger
Then I should see hover effect in list "<list_num_first>"
Then I click on timesheet option in list "<list_num_first>"
When I should see Clicked item page open

When Again I click on mouse hamberger
Then Again I click on timesheet option in list "<list_num_second>"
Then Again I should see Clicked item page open

Examples: 
| url                           | username        | password | list_num_first | list_num_second |
| http://timetrackingwip.prdxnstaging.com/ | admin@prdxn.com | admin123 | 2              | 1               |