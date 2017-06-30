Video library
========================

Video library is a tool that allows you to upload video files to YouTube or Dailymotion channel.

Technologies:
===============
  * PHP
  	* Symfony 3
	  * FOS User Bundle for basic authotization
	* Google SDK
	* Dailymotion SDK
  * CSS, HTML
  * Twig Templating
  * FFPMEG for thumbnail generation

Deploy:
=======
  * Git clone
  * Install [**FFMPEG**][1]
  * Run **composer install** in project root directory and define system parameters. Also you need to define FFMPEG system path, video upload path (web/video) and thumbnail directory path(web/thumbnails)
  * Run **php bin/console doctrine:schema:create** in project root directory to create database.
  
Also, when user connects some social network channel, it access token needs to be refreshed periodically. For these purposes it is necessary to create CRON task to run http endpoint, that refreshes tokens.

For example:

*/15 * * * * wget http://your_video_lib_url/worker/cron
 
You can user scheduler for make our own tasks.

Structure:
==========
**AppBundle**

Entities:

   * Connection (abstract) - is a channel (YouTube or Dailymotion), that user connects. Contains channel info and access token
     * ConnectionRepository
   * DailymotionConnection, YoutubeConnection - connection for specific channel type
     * DailymotionConnectionRepository
     * YoutubeConnectionRepository
   * Share (abstract) - entity, that contains information and statuses abount video sharing to social network.
     * ShareRepository
   * DailymotionShare, YoutubeShare - share record for specific channel type
     * DailymotionShareRepository
     * YoutubeShareRepository
   * User - user entity
     * UserRepository
   * Video - entity, that contains information about uploaded video file
     * VideoRepository
   * VideoMetadata - video file metadata 
   
Controllers:
   * ConnectionController - allows you to connect and disconnect channels
   * MainController - controller for default (main) page
   * LoginController - allows you to authorize with email and password (using [**FOSUserBundle**][2])
   * RegistrationController - allows you to register in system (using [**FOSUserBundle**][2])
   * ShareController - allows you to share your video to social networks
   * VideoController - allows you to upload video and get information

Services
   * DailymotionService - contains methods for publish video to Dailymotion and refresh access token
   * YoutubeService - contains methods for publish video to YouTube and refresh access token
   * FFMpegService - used for generate thumbnail for video
   * MetadataService - get video file metadata
   * Oauth2Service - allows you to connect YouTube or Dailymotion channel
   * UserService - allows you to operate user entity
   * YoutubeService - contains methods for publish video to Youtube and refresh access token
   
   
**Worker bundle**

   * CronController - controller for cron jobs
Entities:
   * SchedulerTask - scheduler task objects for background tasks
     * SchedulerTaskRepository
Service:
   * SchedulerService - service for execute scheduler tasks
   


[1]:  https://ffmpeg.org
[2]:  https://github.com/FriendsOfSymfony/FOSUserBundle