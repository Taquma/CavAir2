/**
 * This snippets saves data in the mysql-db by using a php-cli executable php script
 * Prerequisites:
 *   - installed php5-cli on the linino-/Yùn-side
 *   - the file insertDht22Data.php on a sd-card located @ /mnt/sda1/arduino/
 */


bool insertSensorDataByPhpCli(float temperatureInside, float temperatureOutside, float humidityInside, float humidityOutside, float dewpointInside, float dewpointOutside, float dewpointsDifference, bool fanState) {

  int iTemperatureInside = temperatureInside * 100;
  int iTemperatureOutside = temperatureOutside * 100;
  int iHumidityInside = humidityInside * 100;
  int iHumidityOutside = humidityOutside * 100;
  int iDewpointInside = dewpointInside * 100;
  int iDewpointOutsidee = dewpointOutside * 100;
  int iDewpointsDifference = dewpointsDifference * 100;

  // /usr/bin/php-cli /mnt/sda1/arduino/insertDht22Data.php frequency=100000 grade_of_dryness=3 comment=change sensor_id=1
  char phpCliCallTpl[230] = "/usr/bin/php-cli /mnt/sda1/arduino/insertDht22Data.php temperature_inside=%d temperature_outside=%d humidity_inside=%d humidity_outside=%d dewpoint_inside=%d dewpoint_outside=%d dewpoints_difference=%d fan_state=%d";
  char phpCliCall[275];
  int resultStringLength = sprintf(phpCliCall, phpCliCallTpl, iTemperatureInside, iTemperatureOutside, iHumidityInside, iHumidityOutside, iDewpointInside, iDewpointOutsidee, iDewpointsDifference, (fanState ? 1 : 0));

  Serial.print("phpCliCall: ");
  Serial.println(phpCliCall);
  Serial.print("resultStringLength: ");
  Serial.println(resultStringLength);
  
  if (resultStringLength > 275 || resultStringLength < 0) {
    // error ...
    Serial.println("resultStringLength > 275 or < 0!");
    return false;
  } else {
    Process p;
    p.begin("/usr/bin/php-cli");
    p.addParameter("insertTest.php");
    p.addParameter("temperatureinside=2650");
    Serial.print("runShellCommand: ");
    //Serial.println(p.runShellCommand(phpCliCall));
    Serial.println(p.run());
    /*
    // do nothing until the process finishes, so you get the whole output:
    while(p.running()) {
      digitalWrite(13, HIGH); // wait for Serial to connect.
    };
    digitalWrite(13, LOW);
    */    

    // Read command output:
    char charBuf[80] = "";
    int i = 0;
    while (p.available() > 0) {
      char c = p.read();
      Serial.println(c);
      charBuf[i] = c;
      i += 1;
      if (i == 80) break;
    }
    p.flush();
    p.close();
    Serial.print("Result: ");
    Serial.println(charBuf);
    // if script returned any error...
    if (strcmp(charBuf, "SUCCESS") != 0) {
      Serial.println("Result _not_ SUCCESS!");
      return false;
    }

    /*
    // Print command output on the Serial.
    // A process output can be read with the stream methods
    while (p.available()>0) {
      char c = p.read();
      Serial.print(c);
    }
    */
    // Ensure the last bit of data is sent.
    Serial.flush();
  }
  return true;
}
