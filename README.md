# Login-Software
Please do the following in order to configure and build the app

## Configurations
Follow installation & configuration steps of [Sugar Mobile SDK](http://support.sugarcrm.com/Documentation/Mobile_Solutions/Mobile_SDK/Mobile_SDK_Quick_Start_Guide/#Installation)

## Development
clone the repo and make customisation in Mobile/custom directory

## Building the App
First initiate or update your natives via ./sdk init-native or ./sdk update-native commands

Now you can build the app via following process:
- run the ./sdk bundle-web -s [scheme] -p [ios|android|native] command to create app web data available in the android / iOS project and build it via Android Studio or xCode respectivly
- run the ./sdk build --scheme [debug|qa|store] --platform [ios|android|native] --init-native command to build the binaries using SDK command


Please make sure to have appropriate permission while building the app. Use --verbose to see details of activities performed durng build or bundle process

Thank you
