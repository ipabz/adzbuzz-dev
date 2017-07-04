# Prerequisite

You must have <a target="_blank" href="https://www.virtualbox.org">virtualbox</a> and <a target="_blank" href="https://vagrantup.com">vagrant</a> installed before proceeding below.

# Installation

1) ```cd ~ && git clone https://github.com/ipabz/adzbuzz-dev.git AdzbuzzDevEnv && cd ~/AdzbuzzDevEnv```

2) ```composer install```

3) ```bash scripts/init.sh```

4) Modify ~/AdzbuzzDevEnv/Adzbuzz.yaml file based on your needs

5) Add the follow to your ~/.bashrc file

```
function adzbuzz() {
    ( cd ~/AdzbuzzDevEnv && vagrant $* )
}
```

6) Then run this from anywhere

This starts the virtual machine. At first, this will download the vagrant box which will take as much time depending on your internet connection. Take note that this will only download the box once and then the next time you run the command, it will just start the box you downloaded.

```
adzbuzz up
```
