Feature: Sign in 

Scenario Outline: Verify password copie or not

Given Open browser Start Application "<url>"
When I enter valid "<username>" andd "<password>"
Then I copy the password value
Then I print it for check in console 

Examples: 
| url                           | username        | password |
| http://ittt.prdxnstaging2.com/ | admin@prdxn.com | admin123 |  
