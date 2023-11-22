$VMName = "vm1"

$BMPName = "C:\Users\thiago-tcc\Desktop\$VMName.bmp"

Add-Type -AssemblyName "System.Drawing"
 
$VMCS = Get-WmiObject -Namespace root\virtualization\v2 -Class Msvm_ComputerSystem -Filter "ElementName='$($VMName)'" 

# Get the resolution of the screen at the moment
$video = $VMCS.GetRelated("Msvm_VideoHead")
$xResolution = $video.CurrentHorizontalResolution[0]
$yResolution = $video.CurrentVerticalResolution[0]

function getVMScreenBMP {
    param
    (
        $VM,
        $x,
        $y
    )

    $VMMS = Get-WmiObject -Namespace root\virtualization\v2 -Class Msvm_VirtualSystemManagementService

    # Get screenshot
    $image = $VMMS.GetVirtualSystemThumbnailImage($VMCS, $x, $y).ImageData

    # Transform into bitmap
    $BitMap = New-Object System.Drawing.Bitmap -Args $x,$y,Format16bppRgb565
    $Rect = New-Object System.Drawing.Rectangle 0,0,$x,$y
    $BmpData = $BitMap.LockBits($Rect,"ReadWrite","Format16bppRgb565")
    [System.Runtime.InteropServices.Marshal]::Copy($Image, 0, $BmpData.Scan0, $BmpData.Stride*$BmpData.Height)
    $BitMap.UnlockBits($BmpData)
    
    return $BitMap    
}

(getVMScreenBMP $VMCS $xResolution $yResolution).Save($BMPName)