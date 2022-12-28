import ftplib
import os


class FTP:
    _connected = False
    _ftp = False

    def __init__(self, host, username, password):
        self._host = host
        self._username = username
        self._password = password

    def connect(self):
        if not self._connected:
            try:
                self._ftp = ftplib.FTP(self._host)
                self._ftp.login(self._username, self._password)
                self._connected = True
            except Exception:
                print(f"Exception connecting")
                self.close()
    
    def get_items(self):
        if self._connected:
            try:
                data = self._ftp.nlst()
                return data
            except Exception:
                print(f"Exception getting items")
                self.close()
                return False
        self.connect()
        return False

    def copy_file(self, local_file, remote_file):
        if self._connected:
            try:
                ext = os.path.splitext(local_file)[1]
                if ext in (".rst", ".rsts", ".htm", ".html"):
                    self._ftp.storbinary("STOR " + remote_file, open(local_file, "rb"), 1024)
                return
            except Exception:
                print(f"Excepting copying")
                self.close()
                return
        self.close()
        return False
        


    def delete(self, remote_file):
        if self._connected:
            try:
                self._ftp.delete(remote_file)
            except Exception:
                print(f"Exception deleting")
                return

    def close(self):
        if self._connected:
            try:
                self._ftp.quit()
                self._connected = False
            except Exception:
                print("Exception closing")


