$thisServerHash = ""
$hashVM = ""
$vmName = "vm1"
$apiUser = ""
$apiPass = ""
$uriLogin = 'http://172.22.130.235/public/api/login'
$formLogin = 
@{
    email    = $apiUser
    password = $apiPass    
}
while ($true) {
    $resultLogin = Invoke-RestMethod -Uri $uriLogin -Method Post -Body $formLogin
    $tokenAuth = $resultLogin.access_token
    $headersToken = @{
        Authorization="Bearer $tokenAuth"
    }
    $quando = Get-Date
    $vm = Get-VM $vmName
    $statusToSend = "---State: $($vm.State) ---Status:  $($vm.Status) --Data: $($quando)"
    $BMPName = "C:\Users\thiago-tcc\Desktop\$vmName.bmp"
    $byteArrayBmp1 = "no image"
    if ($vm.State -eq "Running")
    {
        .\save-bmp-vm1.ps1
        $byteArrayBmp1 = Get-Content -Path C:\Users\thiago-tcc\Desktop\$vmName.bmp -Raw
    }
    $base64stringBMP = [Convert]::ToBase64String([IO.File]::ReadAllBytes($BMPName))
    $uriStatusCreate = 'http://172.22.130.235/public/api/status/create'
    $formStatusCreate =
    @{
        hash_server = $thisServerHash
        hash_vm = $hashVM
        filedata = $base64stringBMP
        status = $statusToSend
    }
    $resultStatusCreate = Invoke-RestMethod -Uri $uriStatusCreate -Method Post -Body $formStatusCreate -Headers $headersToken
    $statusToSend
    $uriAcoesPendentes = "http://172.22.130.235/public/api/acoes/$thisServerHash"
    $resultAcoesPendentes = Invoke-RestMethod -Uri $uriAcoesPendentes -Method Get -Headers $headersToken        
    #1 = start, 2 = shutdown, 3 = turn off, 4 = restart
    foreach ($acao in $resultAcoesPendentes.data)
    {
        if ($hashVM -eq $acao.hash_vm)
        {
            $acao_hash_vm = $acao.hash_vm
            $acao_id = $acao.id
            $cmdOutput = "Acao não conhecida"                        
            $uriUpdateAcao = "http://172.22.130.235/public/api/acoes/update/$thisServerHash/$acao_hash_vm/$acao_id"                                                
            if ($acao.acao -eq "1")
            {
                if ($vm.State -eq "Off")
                {
                    $cmd = Start-VM -Name "$vmName"
                    $cmdOutput = "Comando Start executado: $cmd"
                } else 
                {
                    $cmdOutput = "Máquina virtual já está iniciada, comando ignorado"
                }
            }
            if ($acao.acao -eq "2")
            {
                if ($vm.State -eq "Running")
                {
                    $cmd = Stop-VM -Name "$vmName" -Force
                    $cmdOutput = "Comando Stop executado: $cmd"
                } else 
                {
                    $cmdOutput = "Máquina virtual não estava no modo iniciada, comando ignorado"
                }
            }
            if ($acao.acao -eq "3")
            {
                $cmd = Stop-VM -Name "$vmName" -TurnOff
                $cmdOutput = "Comando TurnOff executado: $cmd"
            }
            if ($acao.acao -eq "4")
            {
                if ($vm.State -eq "Running")
                {
                    $cmd = Restart-VM -Name "$vmName" -Force
                    $cmdOutput = "Comando Restart executado: $cmd"
                } else 
                {
                    $cmdOutput = "Máquina virtual não estava no modo iniciada, comando ignorado"
                }
            }
            $formUpdateAcao =
            @{
                resultado = $cmdOutput                
            }
            $resultUpdateAcao = Invoke-RestMethod -Uri $uriUpdateAcao -Method Post -Body $formUpdateAcao -Headers $headersToken            
        }
    }       
    Start-Sleep 15
}