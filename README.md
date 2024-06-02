#  Social media website - Roaler
### LAMP stack Roaler is a social media website where users can create profiles and interact with each other privately and publicly. The website has various pages including Home, Inbox, Search, Explore, Profile and Settings. All of these pages have functionalities of their own which we will explore: 
## Languages and their functionalities 
HTML: Framework 
CSS : Styling. Keyframe animations also used 
Javascript: Client side scripting. All the client side processing like rendering names, getting input are collected and processed by JS. Then they are compiled into a JSON API and then sent to the server using asynchronous javascript AJAX 
PHP : Backend. The JSON files are decoded and processed, which is then used to query the database and send back a response 
MySQL : Datbase. 
Apache : Web server
## Components of the website 
#### Login & Signup allows 
secure login and signup for users. Users can also continue with a previously logged in account by clicking the 'continue with Roaler' button Every user has a unique username. And userid is a unique number given to each user, which is used as primary key in user database 
#### Home 
This is the first page seen when the user logs in. The home page displays some profile info and recommended profiles on the right. On the centre are the public messages (like tweets) uploaded on the platform, most recent first 
#### Adding Friends 
All of the users can find profiles and add them as friends, whome they will be able to DM. They can also be unfriended ### Inbox Based on instagrams inbox. Users see their friends' names. On clicking any one of them the user can DM them privately 
#### Searchbar 
It is a toggle window which can be used to search profiles based on username or name 
#### Profile 
User gets all the details of themselves, like username, name, bio, profile pic and tweets 
#### Explore
This is a page where user can surf around the internet, get headlines, listen to music and much more... Multiple APIs are used here, which include Gemini - for AI search feature, Weather API, Games API and News API. Users can also contribute music to the platform by clicking on the Add Item button below and filling the form. ### Edit Profile User can make changes to their profile 
#### Database
Proper mested queries have been used to retrieve desired data. The different tables in the database are 
##### Users: User info 
##### Messages: To store the public messages 
##### dms: To store the private messages 
##### Friends: To link users who are friends 
##### Media: For storing the explore sectino data 
##### All of the pages in the website are seamless, as the user is not given any constraints while using the website. All exceptions have been handled by the code 
## Future updates: 
Following feature, Custom blog uploading, notifications, image sharing and more! Notifications Image Sharing More Features Coming Soon!
