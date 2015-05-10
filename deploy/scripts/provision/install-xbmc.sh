# For raspbian

# Install XBMC
sudo sh -c "echo 'deb http://archive.mene.za.net/raspbian wheezy contrib' > /etc/apt/sources.list.d/mene.list"
sudo apt-key adv --keyserver keyserver.ubuntu.com --recv-key 5243CDED
sudo apt-get update
sudo apt-get install xbmc

# Add input group if it doesn't exist
egrep -i "^input" /etc/group
if [ $? -ne 0 ]; then
    sudo addgroup --system input
fi

# Make keyboard work
sudo sh -c "echo 'SUBSYSTEM==\"input\", GROUP=\"input\", MODE=\"0660\"' > /etc/udev/rules.d/99-input.rules"
sudo sh -c "echo 'KERNEL==\"tty[0-9]*\", GROUP=\"tty\", MODE=\"0660\"' >> /etc/udev/rules.d/99-input.rules"

sudo sh -c "echo '# input' > /etc/udev/rules.d/10-permissions.rules"
sudo sh -c "echo 'KERNEL==\"mouse*|mice|event*\",   MODE=\"0660\", GROUP=\"input\"' >> /etc/udev/rules.d/10-permissions.rules"
sudo sh -c "echo 'KERNEL==\"ts[0-9]*|uinput\",     MODE=\"0660\", GROUP=\"input\"' >> /etc/udev/rules.d/10-permissions.rules"
sudo sh -c "echo 'KERNEL==\"js[0-9]*\",             MODE=\"0660\", GROUP=\"input\"' >> /etc/udev/rules.d/10-permissions.rules"
sudo sh -c "echo '# tty' >> /etc/udev/rules.d/10-permissions.rules"
sudo sh -c "echo 'KERNEL==\"tty[0-9]*\",            MODE=\"0666\"' >> /etc/udev/rules.d/10-permissions.rules"
sudo sh -c "echo '# vchiq' >> /etc/udev/rules.d/10-permissions.rules"
sudo sh -c "echo 'SUBSYSTEM==\"vchiq\",  GROUP=\"video\", MODE=\"0660\"' >> /etc/udev/rules.d/10-permissions.rules"

# Add current user to groups
#$USER=`awk -F: "/:$(id -u):/{print $1}" /etc/passwd`
$USER=pi
sudo usermod -a -G audio $USER
sudo usermod -a -G video $USER
sudo usermod -a -G input $USER
sudo usermod -a -G dialout $USER
sudo usermod -a -G plugdev $USER
sudo usermod -a -G tty $USER

# Enable autoboot and configure current user
sudo sed -i 's/ENABLED=0/ENABLED=1/g' /etc/default/kodi
sudo sed -i 's/USER=kodi/USER='"$USER"'/g' /etc/default/kodi

# Give enough GPU memory
sudo echo 'gpu_mem=280' >> /boot/config.txt
