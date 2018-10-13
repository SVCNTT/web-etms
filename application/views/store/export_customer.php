<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head></head>
<body>
<table style="border-collapse: collapse; border-spacing: 0;">
	<tr>
		<td colspan="15" style="text-align: center; font-family: Arial, sans-serif; font-size: 12px; color:blue; font-weight: bold; padding: 10px 5px; border:1px solid black; overflow: hidden; word-break: normal;">
            CUSTOMER LIST
		</td>
	</tr>
	<tr>
		<td colspan="15" style="text-align: center; font-family: Arial, sans-serif;  font-size: 12px; color:blue;  font-size: 10px; font-weight: bold; padding: 10px 5px;  border:1px solid black; overflow: hidden; word-break: normal;">
		</td>
	</tr>
	<tr>
		<td style="text-align: center; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; padding: 10px 5px; border-style: solid; border-width: 1px; overflow: hidden; word-break: normal;">
            Code</td>
		<td style="text-align: center; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; padding: 10px 5px; border-style: solid; border-width: 1px; overflow: hidden; word-break: normal;">
            Pharmacy</td>
		<td style="text-align: center; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; padding: 10px 5px; border-style: solid; border-width: 1px; overflow: hidden; word-break: normal;">
            Doctor</td>
		<td style="text-align: center; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; padding: 10px 5px; border-style: solid; border-width: 1px; overflow: hidden; word-break: normal;">
            Tittle</td>
		<td style="text-align: center; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; padding: 10px 5px; border-style: solid; border-width: 1px; overflow: hidden; word-break: normal;">
            Position</td>
		<td style="text-align: center; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; padding: 10px 5px; border-style: solid; border-width: 1px; overflow: hidden; word-break: normal;">
            Specialty</td>
		<td style="text-align: center; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; padding: 10px 5px; border-style: solid; border-width: 1px; overflow: hidden; word-break: normal;">
            Department</td>
		<td style="text-align: center; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; padding: 10px 5px; border-style: solid; border-width: 1px; overflow: hidden; word-break: normal;">
            Class</td>
		<td style="text-align: center; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; padding: 10px 5px; border-style: solid; border-width: 1px; overflow: hidden; word-break: normal;">
            Hospital</td>
		<td style="text-align: center; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; padding: 10px 5px; border-style: solid; border-width: 1px; overflow: hidden; word-break: normal;">
            CustAddress</td>
		<td style="text-align: center; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; padding: 10px 5px; border-style: solid; border-width: 1px; overflow: hidden; word-break: normal;">
            Territory</td>
		<td style="text-align: center; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; padding: 10px 5px; border-style: solid; border-width: 1px; overflow: hidden; word-break: normal;">
            Area</td>
		<td style="text-align: center; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; padding: 10px 5px; border-style: solid; border-width: 1px; overflow: hidden; word-break: normal;">
            Zone</td>
		<td style="text-align: center; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; padding: 10px 5px; border-style: solid; border-width: 1px; overflow: hidden; word-break: normal;">
            MR</td>
		<td style="text-align: center; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; padding: 10px 5px; border-style: solid; border-width: 1px; overflow: hidden; word-break: normal;">
            BU</td>
	</tr>

    <?php foreach($customers as $c) {?>
        <tr>
            <td style="text-align: left; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; padding: 10px 5px; border-style: solid; border-width: 1px; overflow: hidden; word-break: normal;">
                <?php echo $c['store_code'];?>
            </td>
            <td style="text-align: left; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; padding: 10px 5px; border-style: solid; border-width: 1px; overflow: hidden; word-break: normal;">
                <?php echo $c['store_name'];?>
            </td>
            <td style="text-align: left; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; padding: 10px 5px; border-style: solid; border-width: 1px; overflow: hidden; word-break: normal;">
                <?php echo $c['doctor_name'];?>
            </td>
            <td style="text-align: left; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; padding: 10px 5px; border-style: solid; border-width: 1px; overflow: hidden; word-break: normal;">
                <?php echo $c['title'];?>
            </td>
            <td style="text-align: left; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; padding: 10px 5px; border-style: solid; border-width: 1px; overflow: hidden; word-break: normal;">
                <?php echo $c['position'];?>
            </td>
            <td style="text-align: left; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; padding: 10px 5px; border-style: solid; border-width: 1px; overflow: hidden; word-break: normal;">
                <?php echo $c['specialty'];?>
            </td>
            <td style="text-align: left; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; padding: 10px 5px; border-style: solid; border-width: 1px; overflow: hidden; word-break: normal;">
                <?php echo $c['department'];?>
            </td>
            <td style="text-align: left; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; padding: 10px 5px; border-style: solid; border-width: 1px; overflow: hidden; word-break: normal;">
                <?php echo $c['class'];?>
            </td>
            <td style="text-align: left; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; padding: 10px 5px; border-style: solid; border-width: 1px; overflow: hidden; word-break: normal;">
                <?php echo $c['hospital'];?>
            </td>
            <td style="text-align: left; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; padding: 10px 5px; border-style: solid; border-width: 1px; overflow: hidden; word-break: normal;">
                <?php echo $c['address'];?>
            </td>
            <td style="text-align: left; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; padding: 10px 5px; border-style: solid; border-width: 1px; overflow: hidden; word-break: normal;">
                <?php echo $c['area_id'];?>
            </td>
            <td style="text-align: left; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; padding: 10px 5px; border-style: solid; border-width: 1px; overflow: hidden; word-break: normal;">
                <?php echo $c['area_parent_id'];?>
            </td>
            <td style="text-align: left; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; padding: 10px 5px; border-style: solid; border-width: 1px; overflow: hidden; word-break: normal;">
                <?php echo $c['zone_id'];?>
            </td>
            <td style="text-align: left; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; padding: 10px 5px; border-style: solid; border-width: 1px; overflow: hidden; word-break: normal;">
                <!--Unknow-->
            </td>
            <td style="text-align: left; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; padding: 10px 5px; border-style: solid; border-width: 1px; overflow: hidden; word-break: normal;">
                <?php echo $c['product_type_id'];?>
            </td>
        </tr>
    <?php }?>
	
</table>
</body>
</html>