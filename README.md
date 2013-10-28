mass-tag-replacer
=================

source code for my mass tag replacer for tumblr (http://dev.goose.im/tags/)

the intention of making this public isn't so that you can, y'know, upload this to your own server and make the design a lil different and call it your own and steal my thunder, or whatever, though you're certainly free to. i can't stop you! but i hope you won't.

the intention is so that those who would like to create something with the tumblr api, but who are new to coding, can poke around a little, learn how i did it, and maybe, if they really want, build from my code to create something new and amazing. i can't claim to be some kind of code wizard- although i've been called that- and if more experienced developers are looking at this, i'm aware that to you, it may seem like child's play, full of bad coding practices and snippets copied and pasted from the official php docs. in my defense: i was 17 when i coded this. so child's play? actually kind of accurate! 

also, i'm having a hard time getting bugfixes done. any help with cleaning up my gross code and fixing little bugs and helping me implement a couple of feature requests is welcomed, and immensely appreciated. any feedback on my code from those who have been doing this longer than i have is also welcomed. thank you for your time.

current issues:
- support for ask posts (important, but not a personal priority- mostly because i have no idea why ask posts won't come up in the api calls)
- replaces partially matched tags- for instance, if you go to replace the tag "gpoy" with "selfie", it will not only do what it's supposed to, but replace the string "gpoy" in any tags that contain it, turing "gpoy with cat" into "selfie with cat". sometimes this is desired but often not, so an option to replace exact full strings only needs to be added.
- you can replace one tag with multiple tags, but not find posts tagged with multiple tags. this is a tumblr api limitation but can be worked around.
- + does not work
- * does not work
- & does not work
- probably other special characters do not work