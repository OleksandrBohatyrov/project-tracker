<%@ Page Title="Home Page" Language="C#"  AutoEventWireup="true" CodeBehind="Default.aspx.cs" Inherits="WebApplication1._Default" %>

<!DOCTYPE html>
<html xmls="http://www.w3.org/1999/xhtml">
    <head>
        <title>
            andmeta
        </title>
    </head>
    <body>
        <h1>
            xml ja xslt andmete kuvamine
        </h1>
        <br />
        <div>
            <asp:Xml runat="server" DocumentSource="~/projekti-aruanded.xml" TransformSource="~/aruandedLisa.xslt"/>
        </div>
    </body>

</html>