# My week in recap - 01/2020

**Moin**,  
Hey all and welcome to my first blog post.

During the silvester night I finally decided to start my own blog this year.
I haven't planned everything out right now but I think that I will have enough to share with you.
So my posts will let you join my journey as a new lead backend developer, follow my decisions and the process behind, for sure some code things (fun fact: this will be the topic I have the fewest ideas) and some real-life and cooking insights.

This week was pretty short, only 1.5 working days for me.
But it was my start in the new company *Elbgoods GmbH* as a *Lead Backend Developer*.
So a great start for my to write the first post.

Like most first days my one was also a lot of install this, setup that, reading READMEs and notice that they aren't complete and all this stuff.
But this process is one of the most valuable for a project/team/company. 
Because it reminds to document things and possibly also make things easier that grown over time.

Some of my real problems, I will try to fix during the next weeks, were:

### Bitbucket Cloud doesn't have personal access tokens (PAT)

This sounds like a pretty low issue but it grows if you have to use private packages in composer or npm without your own registry server.
In this case the "only" way is to use your SSH-keys.
And I'm sure that there are some ways to handle it with a general set of keys but right now we use the real user/machine ones.
So the local machine keys are copied/mounted into the docker container and used by the package installer inside the container.
Because until now I've lived in a "beautiful" GitHub world this is something super strange and unhandy for me.

But because the docker containers have some more serious issues it's not on top of my priorities right now.

### Docker COPY instead of volumes

Most of the docker users will know the difference - I don't guarantee a perfect definition but for me the major difference is:

* `COPY` copies the file in the container without any back reference
* `volumes` are something like symlinks between the local machine and the container

So if you copy the project source code in the container you have to rebuild it after code changes.
While if you mount them you just have to wait some seconds until the changes get into the container.
Same vice-versa, if you create files in the container they will arrive on your local machine.

To speed up development and make it easier to change things I will change all the copy calls to volumes.
With some more optimisations, like mounting the composer cache and so on.

### Mix of docker and local machine

In most containers no composer was installed - so the way to go was installing all dependencies on the local machine, build the container and check.
The major problem: we have a mixed team of Mac & Linux users, all containers are linux based and I have PHP7.4 installed while the containers are on PHP7.3.
Because I didn't want to rebuild the whole environment on my local machine (php version and extensions) I had to exec the required commands in the container.

That's a total misuse of docker - because at the end it was only a webserver.
But it's also the perfect demonstration why docker was invented and which problem it **should** solve.

-----

But I do it for the learning and what would I learn if everything is perfect?

### Guidelines

One of the first things I've started to do was writing down guidelines, thanks to the [spatie ones](https://guidelines.spatie.be/) for some inspiration.
They are relative basic right now but having one at all is an important step.
We will discuss them during the next week/s and after approval they will be released and I will also write some more about them.

### Nord theme & Starship

During my christmas holidays I've found my new theme for all my tools the [Nord theme](https://www.nordtheme.com/).
And after reading through [webwide.io - Let's talk about terminals](https://webwide.io/threads/lets-talk-about-terminals.592/post-4012) I've found my new shell prompt - [Starship](https://starship.rs/).

For me the nord theme is super calming - something most of the other dark themes are missing.

### DIY flavored oils & sugars

And my last section will be about self made oils & sugars, a perfect present for your friends & family.
It's super easy to do and they are perfect to pimp your next soup, salad, cake or simply eat some bread with oil.
I've started to make some last year and they are super delicious.
Today I've bought a ton of chilis, garlic and lemons to create some chili- and garlic-oil and lemon-sugar.
I will post some recipes during the upcoming weeks - but you will also find a ton of recipes online. ;)
