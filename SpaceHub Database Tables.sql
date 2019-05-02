-- Create Account table
CREATE TABLE Account
(
    Username VARCHAR(100) NOT NULL UNIQUE,
    Password VARCHAR(100) NOT NULL,
	Email NVARCHAR(256) NOT NULL, -- ARE WE HAVING EMAIL VARIABLE?
	FavouriteArticles VARCHAR(MAX),
	FavouriteImages VARCHAR(MAX),
	ThreadsCreated INTEGER,
	ImagesUploaded INTEGER    
);

-- Create Image table
CREATE TABLE Image
(
	Title VARCHAR(100) NOT NULL,
	Date DATE NOT NULL,
	Author VARCHAR(100) REFERENCES ACCOUNT (Username) NOT NULL,
	Likes INTEGER   
);

-- Create Article table
CREATE TABLE Article
(
    Title VARCHAR(100) NOT NULL,
    Date DATE NOT NULL,
    Author VARCHAR(100) REFERENCES ACCOUNT (Username) NOT NULL
	-- WHAT IS THE PURPOSE OF CONTENT AND IMAGE VARIABLES FOR THE DATABASE?
	-- (LOOK AT ARTICLE CLASS IN CLASS DIAGRAM)
);

-- Create Discussion Thread table
CREATE TABLE DiscussionThread
(
	Title VARCHAR(100) NOT NULL,
	Date DATE NOT NULL,
	Author VARCHAR(100) REFERENCES ACCOUNT (Username) NOT NULL,
	Comments VARCHAR(MAX),
	Likes INTEGER
	-- WHAT IS THE PURPOSE OF IMAGES AND POST VARIABLES FOR THE DATABASE?
	-- (LOOK AT DTHREAD CLASS IN CLASS DIAGRAM) 
);

-- Create Event table
CREATE TABLE Event
(
	Title VARCHAR(100) NOT NULL,
	Date DATE NOT NULL,
	Location VARCHAR(100) NOT NULL,
	Time TIME NOT NULL,
	Day VARCHAR(100) NOT NULL	
);

-- Create Weather table
CREATE TABLE Weather
(
	-- ARE WE STORING WEATHER DATA IN OUR DATABASE?
    Temperature INTEGER,
	WindSpeed INTEGER,
	UVIndex INTEGER,
	Humidity INTEGER,
	Sunrise TIME,
	Sunset TIME,
	CloudCover INTEGER,
	Precipitation INTEGER    
);
