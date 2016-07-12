# mass tag replacer

http://tags.goose.im/

wrote this when i was 17. it's bad. complete rewrite + ssl coming soon

## current issues
- support for ask posts (important, but not a personal priority- mostly because i have no idea why ask posts won't come up in the api calls)
- replaces partially matched tags- for instance, if you go to replace the tag "gpoy" with "selfie", it will not only do what it's supposed to, but replace the string "gpoy" in any tags that contain it, turing "gpoy with cat" into "selfie with cat". sometimes this is desired but often not, so an option to replace exact full strings only needs to be added.
- you can replace one tag with multiple tags, but not find posts tagged with multiple tags. this is a tumblr api limitation but can be worked around.
- + does not work
- * does not work
- & does not work
- probably other special characters do not work
