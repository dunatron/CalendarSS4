<%-- TODO NEW NEW https://www.youtube.com/watch?v=5w3fqtIPM8A | HIDDEN SCROLLBAR--%>
<style>

    body {
        background: {$SiteConfig.DefaultBGColor};
        <% if $SiteConfig.UseGradient %>
            background: -moz-linear-gradient(-45deg, {$SiteConfig.GradientBGColor1} 0%, {$SiteConfig.GradientBGColor2} 33%, {$SiteConfig.GradientBGColor3} 71%, {$SiteConfig.GradientBGColor4} 91%);
            background: -webkit-gradient(linear, left top, right bottom, color-stop(0%, {$SiteConfig.GradientBGColor1}), color-stop(33%, {$SiteConfig.GradientBGColor2}), color-stop(71%, {$SiteConfig.GradientBGColor3}), color-stop(91%, {$SiteConfig.GradientBGColor4}));
            background: -webkit-linear-gradient(-45deg, {$SiteConfig.GradientBGColor1} 0%, {$SiteConfig.GradientBGColor2} 33%, {$SiteConfig.GradientBGColor3} 71%, {$SiteConfig.GradientBGColor4} 91%);
            background: -o-linear-gradient(-45deg, {$SiteConfig.GradientBGColor1} 0%, {$SiteConfig.GradientBGColor2} 33%, {$SiteConfig.GradientBGColor3} 71%, {$SiteConfig.GradientBGColor4} 91%);
            background: -ms-linear-gradient(-45deg, {$SiteConfig.GradientBGColor1} 0%, {$SiteConfig.GradientBGColor2} 33%, {$SiteConfig.GradientBGColor3} 71%, {$SiteConfig.GradientBGColor4} 91%);
            background: linear-gradient(135deg, {$SiteConfig.GradientBGColor1} 0%, {$SiteConfig.GradientBGColor2} 33%, {$SiteConfig.GradientBGColor3} 71%, {$SiteConfig.GradientBGColor4} 91%);
        <% end_if %>
    }

</style>
