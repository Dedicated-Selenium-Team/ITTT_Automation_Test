Feature: Project Tab Add

Scenario Outline: Verify click on add myself button and add project.

Given Open browser and Start Application "<url>"
When I enter valid "<username>" and "<password>"
Then User should be logged in and home page should be open
Then User should be in project

<<<<<<< HEAD
Then I click on mouse hambergerr
Then I click Project in listt
=======
Then I click on mouse hamberger
Then I click Project in list
>>>>>>> be355a8771dec742ec18c6f19a0e132c6bcec820
When I click on add new project button
Then I should see a popup
Then I enter detail like "<project_name>" and "<project_code>" and "<client_name>"
When I click on submit button
Then Project "<project_name>" should be added in project list

<<<<<<< HEAD
# When I click on add new project button
# Then I should see a popup
# Then I enter detail like "<project_name>" and "<project_code>" and "<client_name>"
# When I click on submit button
# Then Project "<project_name>" should be added in project list

# Then I click on mouse hamberger
# Then I click Project in list

# When I click on add myself button
# Then Myself Page should be open and select "<project_name>" and  "<designation>"
# Then I click on submit

Examples: 
| url                           | username        | password | project_name | designation | project_code | client_name |
=======
Examples: 
| url                                      | username        | password | project_name | designation | project_code | client_name |
>>>>>>> be355a8771dec742ec18c6f19a0e132c6bcec820
| http://timetrackingwip.prdxnstaging.com/ | admin@prdxn.com | admin123 | Break Loose    | FE_Developer | 1234         | Test        |    
