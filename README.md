Roaler - Social Media Website
Overview
Roaler is a social media website built using the LAMP stack where users can create profiles and interact with each other privately and publicly. The website comprises various pages, each with distinct functionalities. This README provides an overview of the website's structure, the technologies used, and the features available.

Technologies Used
Languages and Their Functionalities
HTML: Structure and framework of the website.
CSS: Styling and keyframe animations.
JavaScript: Client-side scripting. It handles all client-side processing like rendering names and getting input. Inputs are compiled into a JSON API and sent to the server using AJAX.
PHP: Server-side processing. It decodes JSON files, queries the database, and sends back responses.
MySQL: Database management.
Website Components
Login & Signup
Secure Login & Signup: Users can securely log in and sign up.
Persistent Login: Users can continue with a previously logged-in account by clicking the 'Continue with Roaler' button.
Unique User Identifiers: Each user has a unique username and a unique user ID, which serves as the primary key in the user database.
Home
Initial Page: Displays profile information and recommended profiles.
Public Messages: Displays public messages (similar to tweets), with the most recent messages appearing first.
Adding Friends
Find and Add Friends: Users can search for profiles and add them as friends.
Direct Messaging: Friends can be unfriended if desired.
Inbox
DM Interface: Similar to Instagram’s inbox. Users can see their friends' names and DM them privately by clicking on a name.
Searchbar
Profile Search: Toggle window to search for profiles by username or name.
Profile
User Information: Displays username, name, bio, profile picture, and tweets.
Explore
Internet Surfing: Users can explore headlines, listen to music, and more.
APIs Used: Includes Gemini for AI search, Weather API, Games API, and News API.
Music Contribution: Users can add music to the platform by filling out a form.
Edit Profile
Profile Management: Users can make changes to their profile information.
Database Structure
Users Table: Stores user information.
Messages Table: Stores public messages.
DMS Table: Stores private messages.
Friends Table: Links users who are friends.
Media Table: Stores data for the Explore section.
Seamless User Experience: The website provides a seamless user experience without constraints. All exceptions are handled by the code.
Future Updates
Following Feature
Custom Blog Uploading
Notifications
Image Sharing
More Features Coming Soon!
 
 
