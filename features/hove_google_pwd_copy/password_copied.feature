Feature: Sign in 

Scenario Outline: Verify password copie or not

Given Open browser Start Application "<url>"
When I enter valid "<username>" andd "<password>"
Then I copy the password value
Then I print it for check in console 

Examples: 
<<<<<<< HEAD
| url                           | username        | password |
=======
| url                                      | username        | password |
>>>>>>> be355a8771dec742ec18c6f19a0e132c6bcec820
| http://timetrackingwip.prdxnstaging.com/ | admin@prdxn.com | admin123 |  
