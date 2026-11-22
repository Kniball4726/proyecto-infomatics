Set fso = CreateObject("Scripting.FileSystemObject")
scriptDir = fso.GetParentFolderName(WScript.ScriptFullName)

Set WshShell = CreateObject("WScript.Shell")
WshShell.CurrentDirectory = scriptDir

' Iniciar PHP Built-in Server de forma totalmente oculta (0 = SW_HIDE)
WshShell.Run "c:\xampp\php\php.exe -S 0.0.0.0:3000 -t publica", 0, False

' Pausa de 500ms y abrir navegador
WScript.Sleep 500
WshShell.Run "cmd /c start http://localhost:3000/", 0, False
