VERSION 1.0 CLASS
BEGIN
  MultiUse = -1  'True
END
Attribute VB_Name = "Form_Login"
Attribute VB_GlobalNameSpace = False
Attribute VB_Creatable = True
Attribute VB_PredeclaredId = True
Attribute VB_Exposed = False
Option Compare Database

Private Sub btn_entrar_Click()
Dim n�vel
If IsNull(Me.txt_login) Then
    MsgBox "Caixa de login vazia", vbInformation, "Preencha a caixa login"
    Me.txt_login.SetFocus
    ElseIf IsNull(Me.txt_senha) Then
        MsgBox "Caixa de senha vazia", vbInformation, "Preencha a caixa de senha"
        Me.txt_senha.SetFocus
        Else
       If IsNull(DLookup("[Nome]", "Usu�rios", "Nome = '" & Me.txt_login.Value & "' and senha = '" & Me.txt_senha.Value & "'")) Then
            MsgBox "Senha e/ou usu�rio n�o cadastrado", vbInformation, "Falha no login"
            Me.txt_login = ""
            Me.txt_senha = ""
            Else
            n�vel = DLookup("[n�vel]", "Usu�rios", "nome = '" & Me.txt_login.Value & "'")
            If n�vel = 1 Then
                MsgBox "bem-vindo administrador", , "Bem-vindo"
                DoCmd.OpenForm "Entrada"
                Forms!entrada.rtl_entrada.Caption = "Administrador"
                Else
                    MsgBox "Bem-vindo usu�rio padr�o, infelizmente o seu acesso estar� limitado, pois se trata apenas de uma visita", vbInformation, "Bem-vindo"
                    DoCmd.OpenForm "Entrada"
                    Forms!entrada.rtl_entrada.Caption = "Visitante"
                    Forms!entrada.btn_cadastrar.Enabled = False
            End If
       End If
   
End If
End Sub
