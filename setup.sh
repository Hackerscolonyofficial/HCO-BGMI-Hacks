echo "Installing Python..."
pkg install python -y > /dev/null 2>&1
echo "Installing PHP..."
pkg install php -y > /dev/null 2>&1
echo "Installing Cloudflared..."
pkg install cloudflared -y > /dev/null 2>&1
pip install termcolor rich pyfiglet > /dev/null 2>&1

mkdir -p JSON
mv index.php result.php main.py setup.sh JSON
bash run.sh
