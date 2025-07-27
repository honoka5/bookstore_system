' run_customer_stats.vbs
' バッチファイルを非表示で実行するVBS
Dim shell, scriptPath
Set shell = CreateObject("WScript.Shell")
scriptPath = CreateObject("Scripting.FileSystemObject").GetParentFolderName(WScript.ScriptFullName) & "\run_customer_stats.bat"
shell.Run Chr(34) & scriptPath & Chr(34), 0
Set shell = Nothing
