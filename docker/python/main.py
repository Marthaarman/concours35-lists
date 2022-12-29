import ftp
import time
import os
import shutil
import signal

#   settings
path_to_concours35_lists = "files/"
ftp_host = ""
ftp_username = ""
ftp_password = ""
sync_interval_seconds = 60

#   do not edit from here!
stopcommand = False

#   get the files in the local path
def local_get_files():
    global path_to_concours35_lists
    return_items = []
    try:
        item_list = os.listdir(path_to_concours35_lists.rstrip("/"))
        
        for item in item_list:
            if ".rst" in item:
                return_items.append(item)
    except Exception:
        return False
    return return_items


#   get the files in the remote path
def remote_get_files(ftp):
    files = []
    data = ftp.get_items()
    for line in data[2:]:
        file = line
        if "." in file:
            files.append(file)
    return files


def do_loop(_ftp):
    global path_to_concours35_lists
    local_files = local_get_files()
    remote_files = remote_get_files(_ftp)
    if not local_files == False and not remote_files == False:
        for local_file in local_files:
            if local_file not in remote_files:
                _ftp.copy_file( (path_to_concours35_lists.rstrip("/")) + "/" + local_file, local_file)
        
        for remote_file in remote_files:
            if remote_file not in local_files:
                _ftp.delete(remote_file)
    time.sleep(sync_interval_seconds)

    


def sigHandler(signum, frame):
    global stopcommand
    stopcommand = True


if __name__ == "__main__":
    signal.signal(signal.SIGINT, sigHandler)
    signal.signal(signal.SIGHUP, sigHandler)
    signal.signal(signal.SIGTERM, sigHandler)

    _ftp = ftp.FTP(ftp_host, ftp_username, ftp_password)
    _ftp.connect()

    while not stopcommand:
        do_loop(_ftp)
    
    _ftp.close()
        
