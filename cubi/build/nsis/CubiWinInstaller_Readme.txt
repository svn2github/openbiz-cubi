Cubi Windows Installer is based on NSIS.

The installer supporting files are under cubi/build/nsis/
	- cubi_installer_v21.nssp
	- CubiWinInstaller_Readme.txt
	- Openbiz-Cubi_v2.1.0.0_Setup.nsi
	- package/README.txt
	- package/license.txt
	- package/php.ini

Steps to create Cubi Windows Installer
1. Install NSIS from http://nsis.sourceforge.net/Download
   Install NSIS Studio from http://www.mediafire.com/?gnm3d4czslqat, select v2.1 to download

2. Download xmapp lite from http://sourceforge.net/projects/xampp/files/XAMPP%20Windows/1.8.1/

3. Prepare the source
Create c:\dev\build\, then copy the following files to it
	- cubi_installer_v21.nssp
	- CubiWinInstaller_Readme.txt
	- Openbiz-Cubi_v2.1.0.0_Setup.nsi
Create c:\dev\build\package, in this folder
	- add cubi source to cubi-2.1/cubi
	- add xampp source to xampp
	- copy package/README.txt
	- copy package/license.txt
	- copy package/php.ini to xampp/php/php.ini

Make the changes below in xampp/php. This is to add and enable ionCube loader extension 
	copy ioncube_loader_win_5.4.dll* under php/ext/ folder
	*ionCube loader is downloaded from http://www.ioncube.com/loaders.php. Pick "Windows VC9 (x86)" zip file.
	
4. Edit 
Edit the Openbiz-Cubi_v2.1.0.0_Setup.nsi directly with text editor

You can also open NSIS studio and load cubi_installer_v21.nssp to edit it.
After you edit the file, save and click build. The build takes very long, so kill the process using task manager after the build runs for 30 seconds.
The build will re-generate ***_v2.1.0.0_Setup.nsi which can be used in the next Compile step.

5. Compile 
Start NSIS application, open Openbiz-Cubi_v2.1.0.0_Setup.nsi to generate the installer exe file.
Openbiz-Cubi_v2.1.0.0_Setup.exe will be generated under c:\dev\build\installer