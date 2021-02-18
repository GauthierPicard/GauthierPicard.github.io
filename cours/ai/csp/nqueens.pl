:- module(nqueens,[variables/1,consistent/2]).

variables([x(1):[1,2,3,4], x(2):[1,2,3,4], x(3):[1,2,3,4], x(4):[1,2,3,4]]).

consistent((x(I),VI),(x(J),VJ)) :-
    VI =\= VJ,
    I+VI =\= J+VJ,
    I-VI =\= J-VJ.
