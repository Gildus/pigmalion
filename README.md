# Pigmalion
Resolución de Problemas:

Parte 1:
-----------
La parte 1 ejecutamos las pruebas desde la consola con php:

- Problema 1

```bash
php src/parte1/problem1/ChangeString.php
```
Entradas y Salidas:

```
Input: 123 abcd*3*     Output: 123 bcde*3*
Input: **Casa 52       Output: **Dbtb 52

```

- Problema 2

Aqui internamente el codigo procesa un array como parametro; para nuestro ejemplo en el input sera un texto y la salida también. Entradas y Salidas:

````
Input: 1,2,4,5     Output: 1,2,3,4,5
Input: 2,4,9       Output: 2,3,4,5,6,7,8,9
````

```bash
php src/parte1/problem1/CompleteRange.php
```

- Problema 3

Aqui siempre el Input sera simboles de paréntesis. Ejemplo de entradas y salidas:

````
Input: ()())()       Output: ()()()
Input: ()(()         Output: ()()
````

```bash
php src/parte1/problem1/ClearPar.php
```


Parte 2:
-----------
La parte 2 ejecutamos las pruebas desde la consola con php:

````
$ cd parte2/employess 
$ php -S localhost:8888 -t public public/index.php
````

Y en el navegador ingresamos a la URL http://localhost:8888 para ver las opciones que deseamos sobre los empleados que 
son de listados, detalles del empleado y busqueda por Email.

Para la vista del Servicio SOAP es necesario que se ejecute en un NGINX o Apache, etc. y además 
es necesario que se tenga instalado las librerías:

- php-soap
- php-intl

Para ver las definiciones del XML estan en el endpoint http://localhost:8888/v1/wsdl

```xml
<definitions name="serviceEmployee" targetNamespace="http://slim:83/v1" xmlns="http://schemas.xmlsoap.org/wsdl/" xmlns:wsdl="http://schemas.xmlsoap.org/wsdl/" xmlns:tns="http://slim:83/v1" xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap-enc="http://schemas.xmlsoap.org/soap/encoding/" xmlns:soap12="http://schemas.xmlsoap.org/wsdl/soap12/">
   <types>
      <xsd:schema targetNamespace="http://slim:83/v1"/>
   </types>
   <portType name="serviceEmployeePort">
      <operation name="searchBySalary">
         <documentation>Busqueda de Empleados por rango de salarios</documentation>
         <input message="tns:searchBySalaryIn"/>
         <output message="tns:searchBySalaryOut"/>
      </operation>
   </portType>
   <binding name="serviceEmployeeBinding" type="tns:serviceEmployeePort">
      <soap:binding style="rpc" transport="http://schemas.xmlsoap.org/soap/http"/>
      <operation name="searchBySalary">
         <soap:operation soapAction="http://slim:83/v1#searchBySalary"/>
         <input>
            <soap:body use="encoded" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" namespace="http://slim:83/v1"/>
         </input>
         <output>
            <soap:body use="encoded" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" namespace="http://slim:83/v1"/>
         </output>
      </operation>
   </binding>
   <service name="serviceEmployeeService">
      <port name="serviceEmployeePort" binding="tns:serviceEmployeeBinding">
         <soap:address location="http://slim:83/v1"/>
      </port>
   </service>
   <message name="searchBySalaryIn">
      <part name="min" type="xsd:int"/>
      <part name="max" type="xsd:int"/>
   </message>
   <message name="searchBySalaryOut">
      <part name="return" type="soap-enc:Array"/>
   </message>
</definitions>
```

Para Enviar un request y buscar a un empleado por rango de salario usamos la operación searchBySalary

```xml
<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:v1="http://slim:83/v1">
   <soapenv:Header/>
   <soapenv:Body>
      <v1:searchBySalary soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
         <min xsi:type="xsd:int">1000</min>
         <max xsi:type="xsd:int">1400</max>
      </v1:searchBySalary>
   </soapenv:Body>
</soapenv:Envelope>
```

y el resultado es como sigue:

```xml
<SOAP-ENV:Envelope SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://slim:83/v1" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
   <SOAP-ENV:Body>
      <ns1:searchBySalaryResponse>
         <return SOAP-ENC:arrayType="SOAP-ENC:Struct[4]" xsi:type="SOAP-ENC:Array">
            <item xsi:type="SOAP-ENC:Struct">
               <id xsi:type="xsd:string">574daa379545e9af101c2731</id>
               <isOnline xsi:type="xsd:boolean">true</isOnline>
               <salary xsi:type="xsd:string">$1,191.57</salary>
               <age xsi:type="xsd:int">63</age>
               <position xsi:type="xsd:string">developer</position>
               <name xsi:type="xsd:string">Foley Day</name>
               <gender xsi:type="xsd:string">male</gender>
               <email xsi:type="xsd:string">foleyday@fanfare.com</email>
               <phone xsi:type="xsd:string">+0511 (895) 577-2157</phone>
               <address xsi:type="xsd:string">850 Clara Street, Westmoreland, Kansas, 6963</address>
               <skills SOAP-ENC:arrayType="SOAP-ENC:Struct[5]" xsi:type="SOAP-ENC:Array">
                  <item xsi:type="SOAP-ENC:Struct">
                     <skill xsi:type="xsd:string">Python</skill>
                  </item>
                  <item xsi:type="SOAP-ENC:Struct">
                     <skill xsi:type="xsd:string">CSS</skill>
                  </item>
                  <item xsi:type="SOAP-ENC:Struct">
                     <skill xsi:type="xsd:string">C#</skill>
                  </item>
                  <item xsi:type="SOAP-ENC:Struct">
                     <skill xsi:type="xsd:string">JS</skill>
                  </item>
                  <item xsi:type="SOAP-ENC:Struct">
                     <skill xsi:type="xsd:string">Lisp</skill>
                  </item>
               </skills>
            </item>
            <item xsi:type="SOAP-ENC:Struct">
               <id xsi:type="xsd:string">574daa378cb97f935a5c8e2e</id>
               <isOnline xsi:type="xsd:boolean">true</isOnline>
               <salary xsi:type="xsd:string">$1,314.06</salary>
               <age xsi:type="xsd:int">21</age>
               <position xsi:type="xsd:string">developer</position>
               <name xsi:type="xsd:string">Chasity Carver</name>
               <gender xsi:type="xsd:string">female</gender>
               <email xsi:type="xsd:string">chasitycarver@fanfare.com</email>
               <phone xsi:type="xsd:string">+0511 (833) 412-3736</phone>
               <address xsi:type="xsd:string">218 Bulwer Place, Maybell, Utah, 4847</address>
               <skills SOAP-ENC:arrayType="SOAP-ENC:Struct[5]" xsi:type="SOAP-ENC:Array">
                  <item xsi:type="SOAP-ENC:Struct">
                     <skill xsi:type="xsd:string">C#</skill>
                  </item>
                  <item xsi:type="SOAP-ENC:Struct">
                     <skill xsi:type="xsd:string">C#</skill>
                  </item>
                  <item xsi:type="SOAP-ENC:Struct">
                     <skill xsi:type="xsd:string">NoSQL</skill>
                  </item>
                  <item xsi:type="SOAP-ENC:Struct">
                     <skill xsi:type="xsd:string">Java</skill>
                  </item>
                  <item xsi:type="SOAP-ENC:Struct">
                     <skill xsi:type="xsd:string">C#</skill>
                  </item>
               </skills>
            </item>
            <item xsi:type="SOAP-ENC:Struct">
               <id xsi:type="xsd:string">574daa370866cd66710f5519</id>
               <isOnline xsi:type="xsd:boolean">false</isOnline>
               <salary xsi:type="xsd:string">$1,393.47</salary>
               <age xsi:type="xsd:int">22</age>
               <position xsi:type="xsd:string">developer</position>
               <name xsi:type="xsd:string">Greta Mcfadden</name>
               <gender xsi:type="xsd:string">female</gender>
               <email xsi:type="xsd:string">gretamcfadden@fanfare.com</email>
               <phone xsi:type="xsd:string">+0511 (917) 441-3834</phone>
               <address xsi:type="xsd:string">497 Milford Street, Grimsley, Alaska, 9648</address>
               <skills SOAP-ENC:arrayType="SOAP-ENC:Struct[5]" xsi:type="SOAP-ENC:Array">
                  <item xsi:type="SOAP-ENC:Struct">
                     <skill xsi:type="xsd:string">C#</skill>
                  </item>
                  <item xsi:type="SOAP-ENC:Struct">
                     <skill xsi:type="xsd:string">Ruby</skill>
                  </item>
                  <item xsi:type="SOAP-ENC:Struct">
                     <skill xsi:type="xsd:string">PHP</skill>
                  </item>
                  <item xsi:type="SOAP-ENC:Struct">
                     <skill xsi:type="xsd:string">PHP</skill>
                  </item>
                  <item xsi:type="SOAP-ENC:Struct">
                     <skill xsi:type="xsd:string">JS</skill>
                  </item>
               </skills>
            </item>
            <item xsi:type="SOAP-ENC:Struct">
               <id xsi:type="xsd:string">574daa37b6b60c495de67280</id>
               <isOnline xsi:type="xsd:boolean">true</isOnline>
               <salary xsi:type="xsd:string">$1,282.14</salary>
               <age xsi:type="xsd:int">50</age>
               <position xsi:type="xsd:string">developer</position>
               <name xsi:type="xsd:string">Mckee Summers</name>
               <gender xsi:type="xsd:string">male</gender>
               <email xsi:type="xsd:string">mckeesummers@fanfare.com</email>
               <phone xsi:type="xsd:string">+0511 (873) 578-3997</phone>
               <address xsi:type="xsd:string">733 Everett Avenue, Centerville, Colorado, 6706</address>
               <skills SOAP-ENC:arrayType="SOAP-ENC:Struct[5]" xsi:type="SOAP-ENC:Array">
                  <item xsi:type="SOAP-ENC:Struct">
                     <skill xsi:type="xsd:string">Lisp</skill>
                  </item>
                  <item xsi:type="SOAP-ENC:Struct">
                     <skill xsi:type="xsd:string">Python</skill>
                  </item>
                  <item xsi:type="SOAP-ENC:Struct">
                     <skill xsi:type="xsd:string">Python</skill>
                  </item>
                  <item xsi:type="SOAP-ENC:Struct">
                     <skill xsi:type="xsd:string">JS</skill>
                  </item>
                  <item xsi:type="SOAP-ENC:Struct">
                     <skill xsi:type="xsd:string">Java</skill>
                  </item>
               </skills>
            </item>
         </return>
      </ns1:searchBySalaryResponse>
   </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
```

Notas
---

Se usaron:
- PHP 7.0
- Slim Framework 3
- Zend Soap
- NGINX

Existen muchas mejoras que pueden plantearse a nivel de arquitectura, cualquier mejora son bienvenidas.
No se uso un ORM ni un motor o gestor para las vistas, ya que como objetivo se preferia tener 
lo más minimos posible.