# simplePHPquiz

Try it live! http://kitechristianson.com/slc/quizhome.php

This is a quiz web application. It is deployable by dropping it in a web directory, so long as the database is connected. Just upload slcquiz.sql to PHPmyAdmin. 
# So... what does it do?

It is built according to a client's specifications, and under strict time constraints, so it's limited in functionality. I have obtained her permission to upload an open source copy of what I have made.  

 - The web application starts at quizhome.php. quiz.php redirects to quizhome.php if not logged in. 
 - The login system is based of PHPSecureLogin. (https://github.com/chakeda/phpSecureLogin) it's a lovely piece of code, very portable.
 - Users take the quiz (quiz.php), and displays categorical results in a bar graph (results.php). The results takes two sets of data, and are stored as JSON strings in SQL. 
 - Users can share to facebook. It uses the SLC facebook application I made for my client so I might take it out for this version.
 - Administrative actions page, which allows CSV result downloading and database editing.
 - Like all PHP applications, I spent ages making the app work through silly things. (security, post resubmissions, sql problems), and I wish to learn Ruby or Django.

