# Setting up Vagrant environment

For local development the box `debian/jessie` has been chosen as a base it is similar to
the environment run in a Raspberry Pi (Raspbian).

To startup the VM run:

```bash
vagrant up
```

This will download the base box and provision it with the needed components for development.
Your password may be asked several times.

## Fix VBGuest additions for debian box

The VBGuest Additions may fail, reinstall them from the host machine by running:

```bash
vagrant ssh -c "sudo dpkg --purge virtualbox-guest-dkms virtualbox-guest-utils virtualbox-guest-x11"
vagrant vbguest --do install -R
```
