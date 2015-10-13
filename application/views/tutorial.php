<div class="tutorial">
<h2>How to make a Mathematica package</h2>
<p>Mathematica packages and Mathematica applications are collections of Wolfram Language code and other resources that extend Mathematica's native capabilities. There is no difference between package code and code in a notebook, but the former is packaged in a reusable way. In this sense, packages is to Mathematica what classes are to some object oriented languages. Mathematica itself is made up in large part by packages; this was more apparent in the early days of Mathematica when for example Mathematica's plotting capabilities were kept inside a package that had to be loaded before it could be used. Built-in Mathematica functions that are kept in packages today are typically undocumented, and therefore not well known. For example <code>ToAssociation</code> in the <code>GeneralUtilities`</code> package:</p>
<pre class="prettyprint lang-mma"><code>Needs["GeneralUtilities`"]
ToAssociations[{"a" -> 1, "b" -> 2, "c" -> 3}]
(* Out: <|"a" -> 1, "b" -> 2, "c" -> 3|> *)
</code></pre>
<p>In other words, packages are building blocks in large projects, they are reusable components that can be easily shared among Mathematica users through websites such as this. Although anyone who knows how write Wolfram Language code can write a package, there are certain tricks and conventions that must be learned in order to write great packages. This article builds knowledge about package development from the ground up and incorporates those wisdoms.</p>
<div class="panel panel-default">
	<div class="panel-body">
		<ol>
			<li>Packages versus Applications</li>
			<li>Structure</li>
			<li>Namespaces</li>
			<li>Installing and Loading Packages</li>
			<li>Managing Dependencies</li>
			<li>Inspecting Packages that are Built-In</li>
			<li>Writing Packages that Emulate Built-In</li>
				<ol>
					<li>InterpretationBox</li>
					<li>Messages</li>
					<li>SyntaxInformation</li>
					<li>Options</li>
				</ol>
			<li>Example package</li>
			<li>Creating documentation</li>
			<li>Editors</li>
				<ol>
					<li>Workbench</li>
					<li>IntelliJ</li>
				</ol>
			<li>Publishing</li>
				<ol>
					<li>Wolfram Library Archive</li>
					<li>PackageData</li>
				</ol>
		</ol>
	</div>
</div>

<h2>Packages Versus Applications</h2>
<p>One common distinction in the Mathematica world is that between a Mathematica package and a Mathematica application. The canonical online source on the matter is the <a href="http://reference.wolfram.com/workbench/index.jsp?topic=/com.wolfram.eclipse.help/html/tasks/applications/applications.html">Mathematica Development User Guide</a>, where it is plainly stated that a Mathematica application is nothing but a collection of Mathematica packages and other resources. By other resources is meant assets such as images, or code written in other languages. Because Mathematica is capable of integrating other languages through LibraryLink, JLink, RLink and so on, it is very common to write packages that have as their sole purpose to communicate with a library written in another language, to bring its capabilities into Mathematica. JSoupLink is one such application, or package - it can reasonably be called a package because it consists of only one .m file and its Java dependency, and package in this case would refer to the .m file.</p>
<p>Mathematica applications do a wide range of things that can add new fundamental functionality to Mathematica; they can provide stylesheets, palettes, new menu alternatives and, of course, new functions. This tutorial focuses on how to build packages - individual .m or .wl files - and will not touch on palettes, stylesheets and those kinds of things, but will talk about how arrange packages in an application.</p>

<h2>Structure</h2>
</div>