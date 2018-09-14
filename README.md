dsweb
=====

A web server management and web portal for the DarkStar Private FFXI servers.

**State**
- Refactored to use minimal PHP backend with Vue.js frontend
- Gathers data through PHP api endpoints

**Requirements**
- A LAMP stack of sorts, or nginx
- PHP 7.2 (Untested on previous versions of 7.*)
- Latest version of Node & NPM or Yarn

**Screenshots** (out of date)
- Multi-Search: http://i.imgur.com/objeTIM.png
- Character/Account Search: http://i.imgur.com/lB7mZJ6.png
- Character Edit: http://i.imgur.com/VbfUboL.png
- Auction House view: http://i.imgur.com/4oiUtAy.png

**Features**
- Multi search different content from 1 search entry: characters, accounts, skills, items, zones, mobs, etc
- View current/sold items on auction house
- View minimal character details (hard-coded character id for now)
- View server configuration (if present and accessible from dsweb codebase)
- View currently active Notorious Monsters in the field

**Todo**
- Log in as character
-- See character specific data when logged in
-- Buy/Sell to auction house when logged in
-- Backup/Import characters when logged in as character or as admin (dumps json extracts and can be uploaded to any other server)
-- Send/Recieve items (when logged in)
-- Manage equipment (when logged in)
- view, edit, manage anything in the database (admin)
- Manage DarkStar files and configurations (based on version - admin)

Setup
=====
Very simple to get started:

- Open ```config/database.json``` in a text editor
- Enter your dspdb details replacing whats currently there
- run ```composer install && yarn install && yarn build```
- Done
